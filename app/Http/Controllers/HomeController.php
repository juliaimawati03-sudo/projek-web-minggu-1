<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama pelanggan dengan produk dari database.
     */
    public function index()
    {
        $produk = Produk::with('supplier')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('home', compact('produk'));
    }
}
