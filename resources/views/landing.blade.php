@extends('layouts.landing')

@section('title', 'IzinOut - Sistem Perizinan Siswa Digital')

@section('content')
    <x-landing-nav />
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-b from-blue-50 to-white">
        <div class="text-center animate-fade-in-up">
            <img src="https://cdn.builder.io/api/v1/image/assets%2Fe64a5e03458d49e8a674c2d1b43e24e2%2F9459ec78fc684b0fb4e6d517269a4554" alt="Landing Banner" class="mb-10 w-full max-w-xs mx-auto rounded-xl shadow-lg" />
            <h1 class="text-4xl md:text-5xl font-bold text-blue-700 mb-4">Selamat Datang di IzinOut</h1>
            <p class="text-lg text-gray-600 mb-8">Platform digital untuk manajemen perizinan siswa keluar sekolah dengan sistem QR code.</p>
            <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">Masuk ke Sistem</a>
        </div>
    </div>
    <x-landing-footer />
@endsection
