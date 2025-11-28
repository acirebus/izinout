@extends('layouts.dashboard')

@section('dashboard-content')
@section('title', 'IzinOut - Dashboard Admin')

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Siswa</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] }}</p>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 bg-yellow-100 rounded-full">
                <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Menunggu Persetujuan</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_requests'] }}</p>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 bg-green-100 rounded-full">
                <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Izin Aktif</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['active_permissions'] }}</p>
            </div>
        </div>
    </div>

    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 bg-purple-100 rounded-full">
                <i class="fas fa-calendar-day text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Pengajuan Hari Ini</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_requests_today'] }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Permissions -->
<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="card p-6"> 
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.permissions', ['status' => 'diajukan']) }}" 
               class="flex items-center p-3 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors">
                <i class="fas fa-clock text-yellow-600 mr-3"></i>
                <span class="text-gray-900 font-medium">Review Perizinan Pending</span>
                <span class="ml-auto bg-yellow-200 text-yellow-800 px-2 py-1 rounded text-sm">
                    {{ $stats['pending_requests'] }}
                </span>
            </a>

             <a href="{{ route('admin.students') }}" 
               class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                <i class="fas fa-users text-blue-600 mr-3"></i>
                <span class="text-gray-900 font-medium">Lihat Data Siswa</span>
            </a>
        </div>
    </div>
    <!-- Informasi Admin jika ada -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Sekolah</h3>
        <div>
            <p class="text-gray-700 text-sm mb-2">Admin: <span class="font-bold">{{ $user->name }}</span></p>
            <p class="text-gray-700 text-sm mb-2">Nama Sekolah: <span class="font-bold">{{ $school->name }}</span></p>
            <p class="text-gray-700 text-sm mb-2">Alamat: <span class="font-bold">{{ $school->address }}</span></p>
        </div>
    </div>
</div>

<!-- Perizinan Terbaru -->
<div class="card">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900">Perizinan Terbaru</h2>
            <a href="{{ route('admin.permissions') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                Lihat Semua
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentRequests as $permission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $permission->student->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $permission->student->student_number }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $permission->student->class_name }}
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900 max-w-xs truncate">{{ $permission->reason }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>
                                <p>{{ $permission->formatted_time_start }}</p>
                                @if($permission->time_end)
                                    <p class="text-xs">s/d {{ $permission->formatted_time_end }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($permission->status === 'submitted')
                                <span class="badge-warning">Pending</span>
                            @elseif($permission->status === 'waiting_guru')
                                <span class="badge-info">Menunggu Persetujuan Guru</span>
                            @elseif($permission->status === 'approved')
                                <span class="badge-success">Disetujui</span>
                                @if($permission->getActiveStatus() === 'active')
                                    <span class="badge-info ml-1">Aktif</span>
                                @elseif($permission->getActiveStatus() === 'expired')
                                    <span class="badge-danger ml-1">Kadaluarsa</span>
                                @endif
                            @elseif($permission->status === 'rejected')
                                <span class="badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.permission.detail', $permission->permission_id) }}" 
                               class="text-blue-600 hover:text-blue-700">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-gray-300 text-3xl mb-3"></i>
                                <p class="text-gray-500">Belum ada perizinan</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
           
        </div>
    </div>

</div>
@endsection

@php
    $title = 'Dashboard Admin';
    $activeTab = 'dashboard';
@endphp