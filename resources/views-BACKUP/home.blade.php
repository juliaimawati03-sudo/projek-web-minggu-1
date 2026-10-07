@extends('layouts.app')

@section('title', 'SIMANTAP - Temukan Alat Pertanian yang Anda Butuhkan')

@section('content')

    @include('partials.hero')

    @include('partials.kategori', [
        'kategoriList' => [
            ['id' => 'pengolahan-tanah', 'nama' => 'Alat Pengolahan Tanah', 'icon' => '🌱'],
            ['id' => 'pemotong', 'nama' => 'Alat Pemotong', 'icon' => '✂️'],
            ['id' => 'pertanian', 'nama' => 'Alat Pertanian', 'icon' => '🚜'],
            ['id' => 'ternak', 'nama' => 'Perlengkapan Ternak', 'icon' => '🐄'],
        ]
    ])

    @include('partials.produk', [
        'produkList' => [
            ['id' => 1, 'nama' => 'Pacul', 'kategori' => 'pengolahan-tanah', 'deskripsi' => 'Pacul baja kokoh untuk mengolah tanah, menggali, dan membuat bedengan.', 'harga' => 75000, 'stok' => true,  'gambar' => 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?w=500&h=500&fit=crop'],
            ['id' => 2, 'nama' => 'Arit',  'kategori' => 'pemotong',          'deskripsi' => 'Arit tajam untuk memotong rumput dan ranting kecil di lahan.',    'harga' => 45000, 'stok' => true,  'gambar' => 'https://images.unsplash.com/photo-1595428619240-7c0e8e5b3f0b?w=500&h=500&fit=crop'],
            ['id' => 3, 'nama' => 'Bendo', 'kategori' => 'pemotong',          'deskripsi' => 'Bendo/golok serbaguna untuk memotong kayu dan dahan besar.',      'harga' => 85000, 'stok' => true,  'gambar' => 'https://images.unsplash.com/photo-1615486364597-0e8b5b9b8d6e?w=500&h=500&fit=crop'],
            ['id' => 4, 'nama' => 'Sabit', 'kategori' => 'pemotong',          'deskripsi' => 'Sabit ringan untuk memanen padi dan memotong rumput.',           'harga' => 55000, 'stok' => true,  'gambar' => 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?w=500&h=500&fit=crop'],
            ['id' => 5, 'nama' => 'Pisau', 'kategori' => 'pertanian',         'deskripsi' => 'Pisau serbaguna untuk keperluan pertanian sehari-hari.',          'harga' => 35000, 'stok' => true,  'gambar' => 'https://images.unsplash.com/photo-1589994965851-a8f479c573a9?w=500&h=500&fit=crop'],
            ['id' => 6, 'nama' => 'Ungkal', 'kategori' => 'pemotong',         'deskripsi' => 'Ungkal untuk menajamkan alat potong dan membersihkan lahan.',    'harga' => 40000, 'stok' => false, 'gambar' => 'https://images.unsplash.com/photo-1615486364597-0e8b5b9b8d6e?w=500&h=500&fit=crop'],
            ['id' => 7, 'nama' => 'Kalung Sapi', 'kategori' => 'ternak',     'deskripsi' => 'Kalung sapi bahan kulit awet untuk identifikasi ternak.',        'harga' => 60000, 'stok' => true,  'gambar' => 'https://images.unsplash.com/photo-1500595046743-cd271d694d30?w=500&h=500&fit=crop'],
        ]
    ])

    @include('partials.tentang')

    @include('partials.cta')

@endsection