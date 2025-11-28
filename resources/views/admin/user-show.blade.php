@php($title = 'Kelola Data Pengguna')
@extends('layouts.dashboard')

@section('title', 'Detail Pengguna')

@section('dashboard-content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Detail Pengguna</h1>
    <div class="bg-white p-6 rounded shadow max-w-lg">
        <div class="mb-4">
            <span class="font-semibold">Nama:</span> {{ $detail->name }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Email:</span> {{ $detail->email }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">Role:</span> <span class="capitalize">{{ $detail->role }}</span>
        </div>
        <div class="mb-4">
            <span class="font-semibold">Status:</span> {{ $detail->status }}
        </div>
        <div class="mb-4">
            <span class="font-semibold">No. HP:</span> {{ $detail->phone ?? '-' }}
        </div>
        <div class="flex justify-end">
            <a href="{{ route('admin.users.edit', $detail->user_id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded mr-2">Edit</a>
            <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded border border-gray-300">Kembali</a>
        </div>
    </div>
</div>
@endsection
