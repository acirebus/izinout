@extends('layouts.dashboard')

@section('dashboard-content')
@section('title', 'IzinOut - Dashboard Guru')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 bg-blue-100 rounded-full">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-gray-500 text-sm">Total Siswa</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_students'] ?? '-' }}</p>
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
                <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_requests'] ?? '-' }}</p>
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
                <p class="text-2xl font-bold text-gray-900">{{ $stats['active_permissions'] ?? '-' }}</p>
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
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_requests_today'] ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
<div class="card p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">Daftar Izin Menunggu Persetujuan Guru</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Izin</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($permissions as $permission)
                <tr>
                    <td class="px-6 py-4">{{ $permission->student->user->name }}</td>
                    <td class="px-6 py-4">{{ $permission->student->class_name }}</td>
                    <td class="px-6 py-4">{{ $permission->reason }}</td>
                    <td class="px-6 py-4">{{ $permission->time_start }}
                        @if($permission->time_end)
                            - {{ $permission->time_end }}
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('guru.permission.detail', $permission->permission_id) }}" class="text-blue-600 hover:text-blue-700 font-medium">Detail</a>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('guru.approve', $permission->permission_id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded">Approve</button>
                        </form>
                        <form action="{{ route('guru.reject', $permission->permission_id) }}" method="POST" class="inline ml-2">
                            @csrf
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Reject</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">Tidak ada izin menunggu persetujuan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @if($permissions->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $permissions->links() }}
        </div>
    @endif
</div>
@endsection
