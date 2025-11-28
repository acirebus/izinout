@php($title = 'Pengajuan Izin')
@php($activeTab = 'create')
@extends('layouts.dashboard')

@section('title', 'IzinOut - Ajukan Perizinan')

@section('dashboard-content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Ajukan Perizinan</h1>
                    <p class="mt-2 text-gray-600">Isi form di bawah untuk mengajukan perizinan keluar sekolah</p>
                </div>
                <a href="{{ route('student.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow-lg rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Form Perizinan</h2>
                <p class="text-sm text-gray-600">Pastikan semua informasi yang Anda berikan akurat</p>
            </div>

            <form method="POST" action="{{ route('student.permission.store') }}" enctype="multipart/form-data" class="p-6">
                @csrf
                @if($user->status !== 'active')
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728"></path>
                            </svg>
                            Akun Anda nonaktif/diblokir. Tidak dapat mengajukan izin baru.
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div id="popup-izin-aktif" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-40">
                        <div class="bg-white rounded-lg shadow-lg p-8 max-w-md text-center">
                            <h3 class="text-lg font-bold mb-4 text-red-600">Izin Aktif Terdeteksi</h3>
                            <p class="mb-6">{{ session('error') }}</p>
                            <button onclick="document.getElementById('popup-izin-aktif').style.display='none'" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tutup</button>
                        </div>
                    </div>
                @endif


                <!-- ingfo siswa -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Informasi Siswa</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="text-gray-500">Nama:</span>
                            <div class="font-medium">{{ $student->user->name ?? '-' }}</div>
                        </div>
                        <div>
                            <span class="text-gray-500">Kelas:</span>
                            <div class="font-medium">{{ $student->class_name ?? '-' }}</div>
                        </div>
                        <div>
                            <span class="text-gray-500">NIS:</span>
                            <div class="font-medium">{{ $student->student_number ?? 'Belum diatur' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                        <div class="flex">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                        <div class="flex">
                            <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <div class="space-y-6">
                    <!-- and the 'reason' is youu -->
                    <div>
                        <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                                Alasan Izin <span class="text-red-500">*</span>
                            </label>
                            <textarea name="reason" 
                                      id="reason" 
                                      rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('reason') border-red-500 @enderror"
                                      placeholder="jelaskan alasan anda mengajukan izin..."
                                      required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Jelaskan izin anda secara detail</p>
                        </div>

                    <!-- Waktu -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- waktu mulai -->
                        <div>
                            <label for="time_start" class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Mulai <span class="text-red-500">*</span>
                            </label>
                <input type="datetime-local" 
                    name="time_start" 
                    id="time_start" 
                    value="{{ old('time_start', now()->format('Y-m-d\TH:i')) }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('time_start') border-red-500 @enderror"
                    required>
                            @error('time_start')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Masukkan waktu mulai izin</p>
                        </div>

                        <!-- waktu akhir -->
                        <div>
                            <label for="time_end" class="block text-sm font-medium text-gray-700 mb-2">
                                Waktu Selesai (Opsional)
                            </label>
                            <input type="datetime-local" 
                                   name="time_end" 
                                   id="time_end" 
                                   value="{{ old('time_end') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('time_end') border-red-500 @enderror">
                            @error('time_end')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Kosongkan jika tak kembali/pulang</p>
                        </div>
                    </div>

                    <!-- Bukti Pendukung -->
                    <div>
                        <label for="evidence" class="block text-sm font-medium text-gray-700 mb-2">
                            Bukti Pendukung (Opsional)
                        </label>
                        <div class="mt-1 flex flex-col items-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center w-full">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex flex-col items-center w-full">
                                    <div class="flex text-sm text-gray-600 items-center justify-center">
                                        <label for="evidence" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload file</span>
                                            <input id="evidence" name="evidence" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                                        </label>
                                        <p class="pl-1">atau tarik ke sini</p>
                                    </div>
                                    <div id="evidence-preview" class="mt-2"></div>
                                </div>
                                <p class="text-xs text-gray-500">PDF, JPG, JPEG, PNG hingga 2MB</p>
                            </div>
                        </div>
                        @error('evidence')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">
                            Upload bukti pendukung seperti surat sakit, undangan, atau dokumen relevan lainnya.
                        </p>
                    </div>

                    <!-- Pedoman -->
                    <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div class="text-sm text-blue-700">
                                <h4 class="font-medium mb-2">Petunjuk Pengajuan Perizinan:</h4>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Ajukan perizinan setidaknya 30 menit sebelum waktu keluar</li>
                                    <li>Berikan alasan yang jelas dan valid</li>
                                    <li>Upload bukti pendukung jika diperlukan (surat dokter, undangan, dll)</li>
                                    <li>Pastikan informasi yang dimasukkan benar dan lengkap</li>
                                    <li>Perizinan akan diproses oleh admin BK</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                @if($user->status !== 'active') disabled style="opacity:0.5;cursor:not-allowed;" @endif>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Ajukan Perizinan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// update otomatis waktu minimum selesai saat waktu mulai berubah
document.getElementById('time_start').addEventListener('change', function() {
    const startTime = this.value;
    const endTimeInput = document.getElementById('time_end');
    if (startTime) {
    // atur waktu selesai minimal 1 jam setelah waktu mulai
        const startDate = new Date(startTime);
        startDate.setHours(startDate.getHours() + 1);
        endTimeInput.min = startDate.toISOString().slice(0, 16);
    }
});

// preview upload file
document.getElementById('evidence').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('evidence-preview');
    preview.innerHTML = '';
    if (file) {
        preview.innerHTML = `
            <div class="flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                File selected: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)
            </div>
        `;
    }
});
</script>
@endsection