@php($title = 'Kelola Data Pengguna')
@extends('layouts.dashboard')

@section('title', 'Tambah Pengguna')

@section('dashboard-content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Pengguna</h1>
    <form action="{{ route('admin.users.store') }}" method="POST" class="max-w-lg bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="name" class="w-full border px-3 py-2 rounded" required value="{{ old('name') }}">
            @error('name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" class="w-full border px-3 py-2 rounded" required value="{{ old('email') }}">
            @error('email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Role</label>
            <select name="role" class="w-full border px-3 py-2 rounded" required>
                <option value="">Pilih Role</option>
                <option value="admin_bk" {{ old('role')=='admin_bk' ? 'selected' : '' }}>Admin BK</option>
                <option value="guru" {{ old('role')=='guru' ? 'selected' : '' }}>Guru</option>
                <option value="student" {{ old('role')=='student' ? 'selected' : '' }}>Siswa</option>
            </select>
            @error('role')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Status</label>
            <select name="status" class="w-full border px-3 py-2 rounded" required>
                <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            @error('status')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">No. HP</label>
            <input type="text" name="phone" class="w-full border px-3 py-2 rounded" value="{{ old('phone') }}">
            @error('phone')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Password</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
            @error('password')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded" required>
        </div>
        <div id="student-fields" class="mb-4" style="display: none;">
            <label class="block mb-1 font-semibold">NIS (Nomor Induk Siswa)</label>
            <input type="text" name="student_number" class="w-full border px-3 py-2 rounded" value="{{ old('student_number') }}">
            @error('student_number')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
            <label class="block mb-1 font-semibold mt-4">Kelas</label>
            <input type="text" name="class_name" class="w-full border px-3 py-2 rounded" value="{{ old('class_name') }}">
            @error('class_name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('admin.users') }}" class="ml-2 px-4 py-2 rounded border border-gray-300">Batal</a>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.querySelector('select[name=role]');
        const studentFields = document.getElementById('student-fields');
        function toggleStudentFields() {
            if (roleSelect.value === 'student') {
                studentFields.style.display = '';
            } else {
                studentFields.style.display = 'none';
            }
        }
        roleSelect.addEventListener('change', toggleStudentFields);
        toggleStudentFields();
    });
</script>
@endsection
