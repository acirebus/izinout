@php($title = 'Kelola Data Pengguna')
@extends('layouts.dashboard')

@section('title', 'Edit Pengguna')

@section('dashboard-content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Edit Pengguna</h1>
    <form action="{{ route('admin.users.update', $edit->user_id) }}" method="POST" class="max-w-lg bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="name" class="w-full border px-3 py-2 rounded" required value="{{ old('name', $edit->name) }}">
            @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" class="w-full border px-3 py-2 rounded" required value="{{ old('email', $edit->email) }}">
            @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Role</label>
            <select name="role" class="w-full border px-3 py-2 rounded" required>
                <option value="admin_bk" {{ old('role', $edit->role)=='admin_bk' ? 'selected' : '' }}>Admin BK</option>
                <option value="guru" {{ old('role', $edit->role)=='guru' ? 'selected' : '' }}>Guru</option>
                <option value="student" {{ old('role', $edit->role)=='student' ? 'selected' : '' }}>Siswa</option>
            </select>
            @error('role')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Status</label>
            @if($edit->role === 'admin_bk')
                <input type="hidden" name="status" value="active">
                <input type="text" class="w-full border px-3 py-2 rounded bg-gray-100" value="Aktif" readonly>
                <div class="text-xs text-gray-500 mt-1">Akun admin tidak dapat dinonaktifkan.</div>
            @else
                <select name="status" class="w-full border px-3 py-2 rounded" required>
                    <option value="active" {{ old('status', $edit->status)=='active' ? 'selected' : '' }}>Aktif</option>
                    <option value="banned" {{ old('status', $edit->status)=='banned' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            @endif
            @error('status')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">No. HP</label>
            <input type="text" name="phone" class="w-full border px-3 py-2 rounded" value="{{ old('phone', $edit->phone) }}">
            @error('phone')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded">
            @error('password')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('admin.users') }}" class="ml-2 px-4 py-2 rounded border border-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection
