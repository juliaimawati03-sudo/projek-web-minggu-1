@extends('layouts.app')

@section('title', 'SIMANTAP - Temukan Alat Pertanian yang Anda Butuhkan')

@section('content')

    {{-- Hero Section --}}
    @include('partials.hero')

    {{-- Kategori Produk --}}
    @include('partials.kategori', [
        'kategoriList' => [
            ['id' => 'pengolahan-tanah', 'nama' => 'Alat Pengolahan Tanah', 'icon' => '🌱'],
            ['id' => 'pemotong',         'nama' => 'Alat Pemotong',         'icon' => '✂️'],
            ['id' => 'pertanian',        'nama' => 'Alat Pertanian',        'icon' => '🚜'],
            ['id' => 'ternak',           'nama' => 'Perlengkapan Ternak',   'icon' => '🐄'],
        ]
    ])

    {{-- Katalog Produk dari Database --}}
    @include('partials.produk', ['produkList' => $produk])

    {{-- Tentang SIMANTAP --}}
    @include('partials.tentang')

    {{-- Call to Action --}}
    @include('partials.cta')

@endsection