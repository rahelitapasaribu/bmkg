@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <!-- Judul -->
    <h1 class="text-4xl font-bold text-[#01377D] mb-10 text-center">Selamat Datang di Sistem Informasi</h1>

    <!-- Bagian 2 Kolom (Maskot + Teks VS Peta) -->
    <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-10">

        <!-- Kolom Kiri: Maskot -->
        <div class="flex justify-center">
            <img src="{{ asset('images/maskot_bmkg.svg') }}" alt="Maskot" class="w-64 md:w-80">
        </div>

        <!-- Kolom Kanan: Teks + Map -->
        <div class="flex flex-col items-center md:items-start gap-6">
            <!-- Teks -->
            <p class="text-lg text-gray-600 leading-relaxed text-center md:text-left">
                Pantau data dan informasi UPT dengan mudah.
                Sistem ini menyediakan akses cepat dan terintegrasi untuk seluruh unit kerja.
            </p>

            <!-- Map -->
            <img src="{{ asset('images/map.svg') }}" alt="Peta Indonesia" class="w-full max-w-md">
        </div>
    </div>
@endsection
