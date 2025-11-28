@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-white px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="mx-auto h-12 w-12 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-user-graduate text-white text-xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">IzinOut</h1>
                <p class="text-gray-600 mt-2">Sistem Perizinan Siswa</p>
            </div>

            <!-- pesan error-->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mt-0.5"></i>
                        <div class="ml-3">
                            <h3 class="text-red-800 font-medium">Terjadi kesalahan:</h3>
                            <ul class="mt-2 text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- form login -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <!-- pemilihan role -->
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Login sebagai</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors role-option">
                            <input type="radio" name="role" value="admin_bk" class="sr-only" required>
                            <div class="flex flex-col items-center w-full">
                                <i class="fas fa-user-tie text-xl mb-1 text-gray-600"></i>
                                <span class="font-medium text-gray-900">Admin</span>
                            </div>
                            <div class="absolute inset-0 border-2 border-transparent rounded-lg pointer-events-none"></div>
                        </label>
                        <label class="relative flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors role-option">
                            <input type="radio" name="role" value="guru" class="sr-only" required>
                            <div class="flex flex-col items-center w-full">
                                <i class="fas fa-chalkboard-teacher text-xl mb-1 text-gray-600"></i>
                                <span class="font-medium text-gray-900">Guru</span>
                            </div>
                            <div class="absolute inset-0 border-2 border-transparent rounded-lg pointer-events-none"></div>
                        </label>
                        <label class="relative flex items-center p-3 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors role-option">
                            <input type="radio" name="role" value="student" class="sr-only" required>
                            <div class="flex flex-col items-center w-full">
                                <i class="fas fa-user-graduate text-xl mb-1 text-gray-600"></i>
                                <span class="font-medium text-gray-900">Siswa</span>
                            </div>
                            <div class="absolute inset-0 border-2 border-transparent rounded-lg pointer-events-none"></div>
                        </label>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            class="input-field pl-10 w-full bg-white border border-gray-300 rounded-lg py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Masukkan email Anda"
                            required
                            autocomplete="email"
                        >
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="input-field pl-10 w-full bg-white border border-gray-300 rounded-lg py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                            placeholder="Masukkan password Anda"
                            required
                            autocomplete="current-password"
                        >
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        name="remember" 
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                    >
                    <label for="remember" class="ml-2 text-gray-700">Ingat saya</label>
                </div>

                <!-- Submit Button -->

                <button 
                    type="submit" 
                    class="w-full btn-primary py-3 text-base font-semibold"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </button>
            </form>

        

        <!-- Footer -->
        <p class="text-center text-gray-500 text-sm mt-8">
            © 2025 IzinOut. Sistem Perizinan Siswa Digital
        </p>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleOptions = document.querySelectorAll('.role-option');
        roleOptions.forEach(label => {
            const radio = label.querySelector('input[type="radio"]');
            radio.addEventListener('change', () => {
                // Reset semua pilihan
                roleOptions.forEach(l => {
                    l.classList.remove('border-blue-500', 'bg-blue-50');
                    l.querySelector('i').classList.remove('text-blue-600');
                    l.querySelector('span').classList.remove('text-blue-600');
                });
                // Terapkan style pada pilihan yang aktif
                if (radio.checked) {
                    label.classList.add('border-blue-500', 'bg-blue-50');
                    label.querySelector('i').classList.add('text-blue-600');
                    label.querySelector('span').classList.add('text-blue-600');
                }
            });
            // Atur status awal saat halaman dimuat
            if (radio.checked) {
                label.classList.add('border-blue-500', 'bg-blue-50');
                label.querySelector('i').classList.add('text-blue-600');
                label.querySelector('span').classList.add('text-blue-600');
            }
        });
    });
</script>
@endsection