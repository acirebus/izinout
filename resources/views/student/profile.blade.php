@php($title = 'Kelola Profil')
@extends('layouts.dashboard')

@section('title', 'IzinOut - Profil Saya')

@section('dashboard-content')
<div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    <div class="max-w-4xl mx-auto space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-xl md:text-2xl font-medium">Profile Pengguna</h2>
                <p class="text-gray-600">Kelola informasi profil Anda</p>
            </div>
            <a href="{{ route('student.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                Kembali ke Home
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-4 md:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                    <div class="flex flex-col items-center sm:items-start">
                        <div class="h-20 w-20 md:h-24 md:w-24 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-lg md:text-xl font-medium">
                            {{ strtoupper(substr($user->name, 0, 1) . (strstr($user->name, ' ') ? substr(strstr($user->name, ' '), 1, 1) : '')) }}
                        </div>
                        <div class="mt-3 text-center sm:text-left">
                            <div class="flex flex-col sm:flex-row items-center gap-2 mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    </svg>
                                    Siswa
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Aktif
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex-1 space-y-4">
                        <div>
                            <h3 class="text-xl md:text-2xl font-medium text-center sm:text-left">{{ $user->name }}</h3>
                            <p class="text-gray-600 text-center sm:text-left">{{ $user->email }}</p>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2M5 21h2m0 0h2m-2 0v-4a1 1 0 011-1h2a1 1 0 011 1v4"></path>
                                </svg>
                                <span>{{ $user->school->name ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span>{{ $user->phone ?? 'Belum diisi' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                </svg>
                                <span>Kelas {{ $user->student->class_name ?? '' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>NIS: {{ $user->student->student_number ?? '' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex sm:flex-col gap-2">
                        <button type="button" 
                                onclick="toggleEdit()"
                                id="editBtn"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 w-full sm:w-auto">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Profile
                        </button>
                        <div id="editActions" class="hidden flex-col gap-2">
                            <button type="button" 
                                    onclick="saveProfile()"
                                    class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-green-600 hover:bg-green-700">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Simpan
                            </button>
                            <button type="button" 
                                    onclick="cancelEdit()"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-4 md:p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <h3 class="text-lg font-medium">Informasi Personal</h3>
                </div>
                <p class="text-gray-600 mb-6">Informasi dasar tentang akun Anda</p>

                <form id="profileForm" action="{{ route('student.profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="space-y-2">
                            <label for="name" class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                <div id="nameDisplay" class="p-3 bg-gray-50 rounded-md">{{ $user->name }}</div>
                <input type="text" 
                    id="nameInput" 
                    name="name" 
                    value="{{ $user->name }}" 
                    class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="space-y-2">
                            <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                            <div id="emailDisplay" class="p-3 bg-gray-50 rounded-md flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.073a1 1 0 001.242 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ $user->email }}
                            </div>
                            <input type="email" 
                                   id="emailInput" 
                                   name="email" 
                                   value="{{ $user->email }}" 
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="space-y-2">
                            <label for="phone" class="text-sm font-medium text-gray-700">Nomor Telepon</label>
                            <div id="phoneDisplay" class="p-3 bg-gray-50 rounded-md flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                {{ $user->phone ?? 'Belum diisi' }}
                            </div>
                            <input type="text" 
                                   id="phoneInput" 
                                   name="phone" 
                                   value="{{ $user->phone }}" 
                                   class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Role</label>
                            <div class="p-3 bg-gray-50 rounded-md">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    </svg>
                                    Siswa
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6 mb-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Sekolah</label>
                            <div class="p-3 bg-gray-50 rounded-md flex items-center gap-2">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2M5 21h2m0 0h2m-2 0v-4a1 1 0 011-1h2a1 1 0 011 1v4"></path>
                                </svg>
                                {{ $user->school->name ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Kelas</label>
                                <div class="p-3 bg-gray-50 rounded-md flex items-center gap-2">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    </svg>
                                    {{ $user->student->class_name ?? '-' }}
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-gray-700">Nomor Induk Siswa (NIS)</label>
                                <div class="p-3 bg-gray-50 rounded-md font-mono">
                                    {{ $user->student->student_number ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- ingfo akun -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="p-4 md:p-6">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1M8 7h8v10a2 2 0 01-2 2H10a2 2 0 01-2-2V7z"></path>
                    </svg>
                    <h3 class="text-lg font-medium">Informasi Akun</h3>
                </div>
                <p class="text-gray-600 mb-6">Status dan informasi akun Anda</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">User ID</label>
                        <div class="p-3 bg-gray-50 rounded-md font-mono">
                            #{{ $user->user_id }}
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Status Akun</label>
                        <div class="p-3 bg-gray-50 rounded-md">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 mb-6">
                    <label class="text-sm font-medium text-gray-700">Student ID</label>
                    <div class="p-3 bg-gray-50 rounded-md font-mono">
                        #{{ $user->student->student_id ?? '-' }}
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-6">
                    <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <h4 class="text-blue-800 font-medium mb-2">Informasi Penting</h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Perubahan email akan mempengaruhi proses login</li>
                            <li>• Pastikan informasi yang Anda masukkan benar dan aktif</li>
                            <li>• Informasi kelas dan NIS tidak dapat diubah sendiri, hubungi admin jika ada kesalahan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let isEditing = false;
let originalData = {};

function toggleEdit() {
    if (!isEditing) {
    // simpan data asli
        originalData = {
            name: document.getElementById('nameDisplay').textContent,
            email: document.getElementById('emailDisplay').textContent.trim().replace('✉', '').trim(),
            phone: document.getElementById('phoneDisplay').textContent.trim().replace('📞', '').trim()
        };
        
    // tampilkan input field
        document.getElementById('nameDisplay').classList.add('hidden');
        document.getElementById('nameInput').classList.remove('hidden');
        document.getElementById('emailDisplay').classList.add('hidden');
        document.getElementById('emailInput').classList.remove('hidden');
        document.getElementById('phoneDisplay').classList.add('hidden');
        document.getElementById('phoneInput').classList.remove('hidden');
        
    // tampilkan/sembunyikan tombol
        document.getElementById('editBtn').classList.add('hidden');
        document.getElementById('editActions').classList.remove('hidden');
        document.getElementById('editActions').classList.add('flex');
        
        isEditing = true;
    }
}

function cancelEdit() {
    // kembalikan data asli
    document.getElementById('nameInput').value = originalData.name;
    document.getElementById('emailInput').value = originalData.email;
    document.getElementById('phoneInput').value = originalData.phone;
    
    // tampilkan field tampilan
    document.getElementById('nameDisplay').classList.remove('hidden');
    document.getElementById('nameInput').classList.add('hidden');
    document.getElementById('emailDisplay').classList.remove('hidden');
    document.getElementById('emailInput').classList.add('hidden');
    document.getElementById('phoneDisplay').classList.remove('hidden');
    document.getElementById('phoneInput').classList.add('hidden');
    
    // tampilkan/sembunyikan tombol
    document.getElementById('editBtn').classList.remove('hidden');
    document.getElementById('editActions').classList.add('hidden');
    document.getElementById('editActions').classList.remove('flex');
    
    isEditing = false;
}

function saveProfile() {
    // submit form
    document.getElementById('profileForm').submit();
}

// handle pesan sukses/error jika ada
@if(session('success'))
    alert('{{ session('success') }}');
@endif

@if(session('error'))
    alert('{{ session('error') }}');
@endif
</script>
@endpush
@endsection