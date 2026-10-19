<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Tampilkan halaman checkout pemesanan.
     */
    public function checkout(): View
    {
        return view('orders.form');
    }

    /**
     * Tampilkan halaman instruksi pembayaran dan upload bukti transfer.
     */
    public function payment(): View
    {
        return view('orders.payment');
    }

    /**
     * Tampilkan halaman pesanan sukses.
     */
    public function success(): View
    {
        return view('orders.success');
    }

    /**
     * Tampilkan riwayat lacak pesanan saya.
     */
    public function myOrders(Request $request): View
    {
        $dbOrders = collect();
        if (Auth::check()) {
            $dbOrders = Transaksi::with(['details.produk'])
                ->where('pelanggan_id', Auth::id())
                ->latest('tanggal_transaksi')
                ->get();
        }

        return view('orders.my-orders', compact('dbOrders'));
    }

    /**
     * Simpan pesanan pelanggan dan upload bukti transfer ke database MySQL.
     */
    public function submitOrder(Request $request): JsonResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'hp' => 'required|string|max:30',
            'alamat' => 'required|string',
            'latitude' => 'nullable|string|max:50',
            'longitude' => 'nullable|string|max:50',
            'catatan' => 'nullable|string|max:500',
            'payment_method' => 'required|string|max:50',
            'shipping_method' => 'nullable|string|max:50',
            'ongkir' => 'nullable|numeric|min:0',
            'subtotal' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:1',
            'items' => 'required|string', // JSON string array of cart items
            'bukti_transfer' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $items = json_decode($request->items, true);
        if (! is_array($items) || count($items) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Daftar produk pesanan tidak boleh kosong.',
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Generate kode transaksi unik
            $kodeTransaksi = 'ORD-'.date('Ymd').'-'.strtoupper(substr(uniqid(), -4));

            // Simpan bukti transfer jika diunggah
            $buktiPath = null;
            if ($request->hasFile('bukti_transfer') && $request->file('bukti_transfer')->isValid()) {
                $buktiPath = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            }

            // Simpan transaksi utama
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'pelanggan_id' => Auth::id(),
                'kasir_id' => null,
                'nama_pelanggan' => $request->nama,
                'no_hp' => $request->hp,
                'alamat' => $request->alamat,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'total_harga' => $request->total,
                'ongkir' => $request->ongkir ?? 0,
                'metode_pembayaran' => $request->payment_method,
                'bukti_transfer' => $buktiPath,
                'status' => 'menunggu_verifikasi',
                'tanggal_transaksi' => now(),
                'catatan' => $request->catatan,
            ]);

            // Simpan item detail transaksi
            foreach ($items as $item) {
                $produkId = $item['id'] ?? null;
                $qty = (int) ($item['qty'] ?? 1);
                $harga = (int) ($item['harga'] ?? 0);
                $subtotal = $qty * $harga;

                if ($produkId) {
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'produk_id' => $produkId,
                        'jumlah' => $qty,
                        'harga_satuan' => $harga,
                        'subtotal' => $subtotal,
                    ]);

                    // Kurangi stok produk jika mencukupi
                    $produk = Produk::find($produkId);
                    if ($produk && $produk->stok >= $qty) {
                        $produk->decrement('stok', $qty);
                    }
                }
            }

            // Jika user login belum memiliki nomor hp / alamat, simpan sebagai default profil
            if (Auth::check()) {
                $user = Auth::user();
                $updateData = [];
                if (empty($user->no_hp)) {
                    $updateData['no_hp'] = $request->hp;
                }
                if (empty($user->alamat)) {
                    $updateData['alamat'] = $request->alamat;
                }
                if (empty($user->latitude) && ! empty($request->latitude)) {
                    $updateData['latitude'] = $request->latitude;
                }
                if (empty($user->longitude) && ! empty($request->longitude)) {
                    $updateData['longitude'] = $request->longitude;
                }
                if (! empty($updateData)) {
                    $user->update($updateData);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat!',
                'kode_transaksi' => $transaksi->kode_transaksi,
                'transaksi_id' => $transaksi->id,
                'redirect' => route('orders.success'),
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memproses pesanan: '.$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat menyimpan pesanan: '.$e->getMessage(),
            ], 500);
        }
    }
}
