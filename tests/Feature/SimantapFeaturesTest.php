<?php

namespace Tests\Feature;

use App\Models\Pengeluaran;
use App\Models\Produk;
use App\Models\Supplier;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SimantapFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected User $kasir;

    protected User $pelanggan;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::firstOrCreate(
            ['username' => 'admin_test'],
            [
                'nama' => 'Admin Pengujian',
                'password' => 'password',
                'role' => 'admin',
                'no_hp' => '0811111111',
                'alamat' => 'Kantor SIMANTAP Jombang',
            ]
        );

        $this->kasir = User::firstOrCreate(
            ['username' => 'kasir_test'],
            [
                'nama' => 'Kasir Pengujian',
                'password' => 'password',
                'role' => 'kasir',
                'no_hp' => '0822222222',
                'alamat' => 'Outlet SIMANTAP Jombang',
            ]
        );

        $this->pelanggan = User::firstOrCreate(
            ['username' => 'pelanggan_test'],
            [
                'nama' => 'Pelanggan Pengujian',
                'password' => 'password',
                'role' => 'pelanggan',
                'no_hp' => '0833333333',
                'alamat' => 'Desa Sambong Jombang',
            ]
        );
    }

    /**
     * Test Kasir dapat melihat daftar pesanan masuk.
     */
    public function test_kasir_can_view_pesanan_masuk(): void
    {
        $response = $this->actingAs($this->kasir)->get(route('kasir.pesanan.index'));
        $response->assertStatus(200);
        $response->assertSee('Pesanan Masuk');
    }

    /**
     * Test Kasir memverifikasi pesanan masuk dan status berubah menjadi diproses.
     */
    public function test_kasir_can_verify_pesanan_and_update_status(): void
    {
        $transaksi = Transaksi::create([
            'kode_transaksi' => 'TEST-VERIF-'.uniqid(),
            'pelanggan_id' => $this->pelanggan->id,
            'nama_pelanggan' => 'Budi Pengujian',
            'no_hp' => '08123456789',
            'alamat' => 'Jl. Uji Coba No. 12',
            'total_harga' => 150000,
            'status' => 'menunggu_verifikasi',
            'metode_pembayaran' => 'Transfer BCA',
            'tanggal_transaksi' => now(),
        ]);

        $response = $this->actingAs($this->kasir)
            ->post(route('kasir.pesanan.verifikasi', $transaksi->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('transaksi', [
            'id' => $transaksi->id,
            'status' => 'diproses',
            'kasir_id' => $this->kasir->id,
        ]);
    }

    /**
     * Test Kasir dapat melihat riwayat transaksi tanpa error.
     */
    public function test_kasir_can_view_riwayat_transaksi(): void
    {
        // Pastikan ada transaksi selesai
        Transaksi::create([
            'kode_transaksi' => 'TEST-SELESAI-'.uniqid(),
            'pelanggan_id' => $this->pelanggan->id,
            'kasir_id' => $this->kasir->id,
            'nama_pelanggan' => 'Siti Pengujian',
            'no_hp' => '08123456780',
            'alamat' => 'Jl. Mawar No. 1',
            'total_harga' => 200000,
            'status' => 'selesai',
            'metode_pembayaran' => 'Tunai',
            'tanggal_transaksi' => now(),
        ]);

        $response = $this->actingAs($this->kasir)->get(route('kasir.riwayat.index'));
        $response->assertStatus(200);
        $response->assertSee('Riwayat Transaksi');
    }

    /**
     * Test Admin dapat melihat halaman transaksi penjualan dan detailnya.
     */
    public function test_admin_can_view_transaksi_penjualan(): void
    {
        $transaksi = Transaksi::create([
            'kode_transaksi' => 'TEST-ADMIN-'.uniqid(),
            'pelanggan_id' => $this->pelanggan->id,
            'nama_pelanggan' => 'Admin Test Trx',
            'no_hp' => '08123456789',
            'alamat' => 'Alamat Test',
            'total_harga' => 100000,
            'status' => 'diproses',
            'metode_pembayaran' => 'Tunai',
            'tanggal_transaksi' => now(),
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.transaksi.index'));
        $response->assertStatus(200);
        $response->assertSee('Transaksi Penjualan');

        $showResponse = $this->actingAs($this->admin)->get(route('admin.transaksi.show', $transaksi->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee($transaksi->kode_transaksi);
    }

    /**
     * Test Admin mencatat pembelian supplier dan tersimpan ke pengeluaran & catatan_keuangan.
     */
    public function test_admin_can_store_pembelian_supplier(): void
    {
        $supplier = Supplier::create([
            'nama_supplier' => 'CV Sumber Makmur Mandiri',
            'no_telepon' => '0819999999',
            'alamat' => 'Jombang',
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.pembelian.store'), [
            'supplier_id' => $supplier->id,
            'tanggal' => now()->format('Y-m-d'),
            'nominal' => 750000,
            'keterangan' => 'Restok 10 unit alat semprot',
        ]);

        $response->assertRedirect(route('admin.pembelian.create'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pengeluaran', [
            'supplier_id' => $supplier->id,
            'nominal' => 750000,
        ]);

        $this->assertDatabaseHas('catatan_keuangan', [
            'nominal' => -750000,
        ]);
    }

    /**
     * Test pelanggan checkout online dan tersimpan ke database MySQL.
     */
    public function test_customer_can_submit_order_to_database(): void
    {
        Storage::fake('public');

        $supplier = Supplier::create([
            'nama_supplier' => 'PT Mitra Tani Uji',
            'no_telepon' => '08123123123',
            'alamat' => 'Jombang',
        ]);

        $produk = Produk::create([
            'nama_produk' => 'Cangkul Baja Pengujian',
            'kategori' => 'pengolahan-tanah',
            'harga' => 85000,
            'stok' => 20,
            'supplier_id' => $supplier->id,
            'deskripsi' => 'Alat uji cangkul',
        ]);

        $file = UploadedFile::fake()->image('bukti_transfer.jpg');

        $payload = [
            'nama' => 'Joko Petani',
            'hp' => '085712345678',
            'alamat' => 'Desa Tani Makmur RT 01 RW 02 Jombang',
            'latitude' => '-7.5468',
            'longitude' => '112.2331',
            'catatan' => 'Mohon dikirim pagi hari',
            'payment_method' => 'Transfer BCA',
            'shipping_method' => 'kurir_toko',
            'ongkir' => 15000,
            'subtotal' => 85000,
            'total' => 100000,
            'items' => json_encode([
                [
                    'id' => $produk->id,
                    'qty' => 1,
                    'harga' => 85000,
                ],
            ]),
            'bukti_transfer' => $file,
        ];

        $response = $this->actingAs($this->pelanggan)->postJson(route('orders.submit'), $payload);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('transaksi', [
            'nama_pelanggan' => 'Joko Petani',
            'status' => 'menunggu_verifikasi',
            'metode_pembayaran' => 'Transfer BCA',
        ]);
    }
}
