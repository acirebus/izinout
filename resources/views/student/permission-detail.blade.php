@extends('layouts.dashboard')

@section('dashboard-content')
@section('title', 'Detail Perizinan #' . $permission->permission_id)


<!-- detail izin -->
<div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    <div class="max-w-4xl mx-auto">
    
        <!-- status izin -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4 md:mb-6">
            <div class="p-4 md:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-3">
                    <div class="flex items-center gap-3">
                        @if($permission->status === 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Disetujui</span>
                            @if(!$permission->isExpired())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Expired</span>
                            @endif
                        @elseif($permission->status === 'rejected')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Ditolak</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Diajukan</span>
                        @endif
                        <div class="ml-4">
                            <h3 class="text-base md:text-lg font-medium">Status Perizinan</h3>
                            <p class="text-sm text-gray-600">ID: #{{ $permission->permission_id }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- card qr -->
        @if($permission->status === 'approved' && !$permission->isExpired())
            <div class="bg-green-50 border border-green-200 rounded-lg shadow-sm mb-4 md:mb-6">
                <div class="p-4 md:p-6">
                    <div class="flex items-center gap-2 text-base md:text-lg font-medium text-green-800 mb-2">
                        <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 8h4m4 0V4m-4 4h2m2 0h2M4 4h4v4H4V4z"></path>
                        </svg>
                        QR Code Perizinan Aktif
                    </div>
                    <p class="text-green-700 text-sm mb-4">Tunjukkan QR code ini kepada penjaga gerbang saat keluar/masuk sekolah</p>
                    <div class="flex flex-col lg:flex-row gap-6 items-start mt-4">
                        <!-- QR Code -->
                        <div class="flex-shrink-0 mx-auto lg:mx-0">
                            <div class="bg-white p-4 rounded-lg border-2 border-gray-300 inline-block">
                                <div class="w-48 h-48 bg-white border border-gray-200 relative flex items-center justify-center">
                                    <img src="{{ route('qr.generate', $permission->permission_id) }}" alt="QR Code" class="w-44 h-44 mx-auto" />
                                </div>
                                <div class="mt-2 text-center">
                                    <p class="text-xs text-gray-500">QR Code</p>
                                    <p class="text-xs text-gray-400">#{{ $permission->permission_id }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- instruksi dan izin -->
                        <div class="flex-1 space-y-4">
                            <div class="bg-white p-4 rounded-lg border border-green-200">
                                <div class="flex items-start gap-3 mb-3">
                                    <svg class="h-5 w-5 text-green-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5-4v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2z"></path>
                                    </svg>
                                    <div>
                                        <h4 class="text-green-800 font-medium mb-2">Instruksi untuk Penjaga Gerbang:</h4>
                                        <ul class="text-sm text-green-700 space-y-1">
                                            <li>• Scan QR code untuk memverifikasi perizinan</li>
                                            <li>• Pastikan status perizinan "DISETUJUI" dan "AKTIF"</li>
                                            <li>• Cocokkan nama siswa dengan identitas</li>
                                            <li>• Catat waktu keluar/masuk di sistem</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white p-4 rounded-lg border border-green-200">
                                <h4 class="text-green-800 font-medium mb-3">Informasi Perizinan:</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                                    <div>
                                        <span class="text-gray-600">ID Perizinan:</span>
                                        <p class="text-green-800 font-medium">#{{ $permission->permission_id }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Nama Siswa:</span>
                                        <p class="text-green-800 font-medium break-words">{{ $permission->student && $permission->student->user ? $permission->student->user->name : '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Kelas:</span>
                                        <p class="text-green-800 font-medium">{{ $permission->student && $permission->student->class_name ? $permission->student->class_name : '-' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Waktu Izin:</span>
                                        <p class="text-green-800 font-medium text-xs break-words">
                                            @if($permission->time_start)
                                                {{ $permission->time_start->format('d/m/Y H:i') }} - {{ $permission->auto_time_end->format('d/m/Y H:i') }}
                                            @else
                                                -
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-blue-50 p-3 rounded-lg border border-blue-200">
                                <p class="text-xs text-blue-700">
                                    <strong>Catatan:</strong> QR code ini berlaku selama periode izin yang telah ditentukan. 
                                    Jika ada masalah dengan scanning, hubungi admin BK atau tunjukkan screenshot halaman ini.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- waktu izin habis/expired -->
        @if($permission->status === 'approved' && $permission->isExpired())
            <div class="bg-gray-50 border border-gray-200 rounded-lg shadow-sm mb-4 md:mb-6">
                <div class="p-4 md:p-6">
                    <div class="flex items-center gap-2 text-base md:text-lg font-medium text-gray-800 mb-2">
                        <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Perizinan Sudah Berakhir
                    </div>
                    <p class="text-gray-700 text-sm mb-4">
                        Izin ini sudah tidak dapat digunakan lagi karena waktu yang ditentukan sudah berlalu
                    </p>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <div class="flex items-start gap-3">
                            <svg class="h-5 w-5 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.96-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <div>
                                <h4 class="text-gray-800 font-medium mb-2">Informasi Penting:</h4>
                                <ul class="text-sm text-gray-700 space-y-1">
                                    <li>• Izin ini sudah melewati batas waktu yang ditentukan</li>
                                    <li>• QR code tidak lagi dapat digunakan untuk keluar/masuk</li>
                                    <li>• Jika masih memerlukan izin, ajukan perizinan baru</li>
                                    <li>• Hubungi admin BK jika ada pertanyaan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

       
        

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
            <!-- ingfo siswa -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 md:p-6">
                    <div class="flex items-center gap-2 text-base md:text-lg font-medium mb-4">
                        <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Siswa
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Nama Siswa</p>
                            <p class="font-medium break-words">{{ $permission->student->user->name ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kelas</p>
                            <p class="font-medium">{{ $permission->student->class_name ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nomor Siswa</p>
                            <p class="font-mono font-medium">{{ $permission->student->student_number ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="text-sm break-words">{{ $permission->student->user->email ?? '' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ingfo waktu -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 md:p-6">
                    <div class="flex items-center gap-2 text-base md:text-lg font-medium mb-4">
                        <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Waktu
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Waktu Mulai</p>
                            <p class="text-sm md:text-base font-medium break-words">
                                {{ $permission->time_start ? $permission->time_start->format('d/m/Y H:i') : 'Tidak ditentukan' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Waktu Selesai</p>
                            <p class="text-sm md:text-base font-medium break-words">
                                {{ $permission->time_end ? $permission->time_end->format('d/m/Y H:i') : 'Tidak ditentukan' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Diajukan Pada</p>
                            <p class="text-sm md:text-base font-medium break-words">{{ $permission->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        
                        <!-- Status Waktu -->
                        @if($permission->status === 'disetujui')
                            <div class="pt-2 border-t border-gray-200">
                                <p class="text-sm text-gray-600">Status Waktu</p>
                                <p class="text-sm font-medium break-words {{ !$permission->isExpired() ? 'text-blue-600' : 'text-gray-500' }}">
                                    {{ !$permission->isExpired() ? 'Masih berlaku' : 'Sudah berakhir' }}
                                    @if($permission->time_end && $permission->isExpired())
                                        <span class="block text-xs text-gray-500 mt-1">
                                            Berakhir pada: {{ $permission->time_end->format('d/m/Y H:i') }}
                                        </span>
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- detail izin -->
            <div class="lg:col-span-2 bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="p-4 md:p-6">
                    <div class="flex items-center gap-2 text-base md:text-lg font-medium mb-4">
                        <svg class="h-4 w-4 md:h-5 md:w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Detail Perizinan
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Alasan Izin</p>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-sm md:text-base break-words">{{ $permission->reason }}</p>
                            </div>
                        </div>

                    @if($permission->evidence_path)
                        <div>
                            <p class="text-sm text-gray-600 mb-2">Bukti Pendukung</p>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                @php
                                    $ext = pathinfo($permission->evidence_path, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif','bmp','webp']))
                                    <img src="{{ Storage::url($permission->evidence_path) }}" alt="Bukti" class="max-w-xs rounded mb-2">
                                @else
                                    <p class="text-sm text-blue-600 font-medium">File bukti tersedia</p>
                                    <a href="{{ Storage::url($permission->evidence_path) }}" target="_blank" class="text-xs text-blue-500 underline">
                                        Lihat file bukti
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif

                        <div class="pt-4 border-t border-gray-200">
                            <h4 class="text-sm md:text-base font-medium mb-3">Timeline Perizinan</h4>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm md:text-base font-medium">Perizinan diajukan</p>
                                        <p class="text-xs text-gray-500 break-words">{{ $permission->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-yellow-400 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm md:text-base font-medium">Menunggu persetujuan guru</p>
                                        <p class="text-xs text-gray-500 break-words">{{ $permission->waiting_guru_at ? $permission->waiting_guru_at->format('d/m/Y H:i') : $permission->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                @if($permission->status === 'submitted' || $permission->status === 'approved' || $permission->status === 'rejected')
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm md:text-base font-medium">Disetujui guru dan diteruskan ke admin</p>
                                        <p class="text-xs text-gray-500 break-words">{{ $permission->formatted_guru_approved_at ?? '-' }}</p>
                                    </div>
                                </div>
                                @endif
                                @if($permission->status === 'approved')
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-green-600 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm md:text-base font-medium">Perizinan disetujui</p>
                                        <p class="text-xs text-gray-500 break-words">{{ $permission->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                @elseif($permission->status === 'rejected')
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-red-600 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm md:text-base font-medium">Perizinan ditolak</p>
                                        <p class="text-xs text-gray-500 break-words">{{ $permission->updated_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                                @endif

                                @if($permission->status === 'disetujui')
                                    <div class="flex items-start gap-3">
                                        <div class="w-2 h-2 rounded-full mt-2 {{ !$permission->isExpired() ? 'bg-green-600' : 'bg-gray-400' }}"></div>
                                        <div class="flex-1">
                                            <p class="text-sm md:text-base font-medium">
                                                {{ !$permission->isExpired() ? 'QR Code aktif dan siap digunakan' : 'Perizinan berakhir' }}
                                            </p>
                                            <p class="text-xs text-gray-500 break-words">
                                                {{ !$permission->isExpired() ? 'Dapat ditunjukkan kepada penjaga gerbang' : ($permission->time_end ? 'Berakhir pada ' . $permission->time_end->format('d/m/Y H:i') : 'Waktu tidak ditentukan') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection