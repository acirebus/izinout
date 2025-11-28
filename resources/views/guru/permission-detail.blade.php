@extends('layouts.dashboard')

@section('title', 'Detail Perizinan #' . $permission->permission_id)

@section('dashboard-content')
<div class="min-h-screen bg-gray-50 p-4 sm:p-6">
    <div class="max-w-4xl mx-auto">
        <div class="sm:hidden mb-4">
            <h2 class="text-lg font-medium">Detail Perizinan #{{ $permission->permission_id }}</h2>
        </div>

        <!-- card status izin -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-4 md:mb-6">
            <div class="p-4 md:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-3">
                    <div class="flex items-center gap-3">
                        @if($permission->status === 'approved')
                            <div class="flex items-center gap-2">
                                <svg class="h-5 w-5 md:h-6 md:w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @if($permission->isExpired())
                                    <svg class="h-4 w-4 md:h-5 md:w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>
                        @elseif($permission->status === 'rejected')
                            <svg class="h-5 w-5 md:h-6 md:w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="h-5 w-5 md:h-6 md:w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.96-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        @endif
                        <div>
                            <h3 class="text-base md:text-lg font-medium">Status Perizinan</h3>
                            <p class="text-sm text-gray-600">ID: #{{ $permission->permission_id }}</p>
                        </div>
                    </div>
                    <!-- Status Badges & Action Buttons -->
                    <div class="flex items-center gap-2 flex-wrap">
                        @if($permission->status === 'approved')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Disetujui
                            </span>
                            @if(!$permission->isExpired())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Kadaluarsa
                                </span>
                            @endif
                        @elseif($permission->status === 'rejected')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Ditolak
                            </span>
                        @elseif($permission->status === 'submitted')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Diajukan
                            </span>
                        @elseif($permission->status === 'waiting_guru')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Menunggu Persetujuan Guru
                            </span>
                        @endif
                        @if($permission->status === 'waiting_guru')
                            <form action="{{ route('guru.approve', $permission->permission_id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded">Setujui</button>
                            </form>
                            <form action="{{ route('guru.reject', $permission->permission_id) }}" method="POST" class="inline ml-2">
                                @csrf
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Tolak</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Waktu dan Siswa -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
            <!-- Informasi siswa -->
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
                            <p class="font-medium break-words">{{ $permission->student->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kelas</p>
                            <p class="font-medium">{{ $permission->student->class_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Nomor Induk</p>
                            <p class="font-mono font-medium">{{ $permission->student->student_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Email</p>
                            <p class="text-sm break-words">{{ $permission->student->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Informasi Waktu -->
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
                            <p class="text-sm md:text-base font-medium break-words">{{ $permission->time_start }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Waktu Selesai</p>
                            <p class="text-sm md:text-base font-medium break-words">{{ $permission->time_end ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Diajukan Pada</p>
                            <p class="text-sm md:text-base font-medium break-words">{{ $permission->created_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Detail Perizinan -->
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
                        <!-- Timeline Perizinan -->
                        <div class="pt-4 border-t border-gray-200">
                            <h4 class="text-sm md:text-base font-medium mb-3">Timeline Perizinan</h4>
                            <div class="space-y-3">
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm md:text-base font-medium">Perizinan diajukan</p>
                                        <p class="text-xs text-gray-500 break-words">
                                            {{ $permission->created_at }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm md:text-base font-medium">Perizinan diajukan</p>
                                        <p class="text-xs text-gray-500 break-words">{{ $permission->created_at }}</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-yellow-400 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm md:text-base font-medium">Menunggu persetujuan guru</p>
                                        <p class="text-xs text-gray-500 break-words">{{ $permission->waiting_guru_at ? $permission->waiting_guru_at : $permission->created_at }}</p>
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
                                        <p class="text-xs text-gray-500 break-words">{{ $permission->updated_at }}</p>
                                    </div>
                                </div>
                                @elseif($permission->status === 'rejected')
                                <div class="flex items-start gap-3">
                                    <div class="w-2 h-2 bg-red-600 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm md:text-base font-medium">Perizinan ditolak</p>
                                        <p class="text-xs text-gray-500 break-words">{{ $permission->updated_at }}</p>
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
