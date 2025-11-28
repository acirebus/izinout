@php($title = 'Riwayat Izin Siswa')
@php($activeTab = 'riwayatizin')
@extends('layouts.dashboard')

@section('dashboard-content')
@section('title', 'IzinOut - Riwayat Perizinan')
<div class="card p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">Riwayat Izin Semua Siswa</h2>
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Izin</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th>
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
                        @if($permission->status === 'waiting_guru')
                            <span class="badge-info">Menunggu Persetujuan Guru</span>
                        @elseif($permission->status === 'submitted')
                            <span class="badge-warning">Pending Admin</span>
                        @elseif($permission->status === 'approved')
                            <span class="badge-success">Disetujui</span>
                        @elseif($permission->status === 'rejected')
                            <span class="badge-danger">Ditolak</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('guru.permission.detail', $permission->permission_id) }}" class="text-blue-600 hover:text-blue-700 font-medium">Detail</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">Tidak ada riwayat izin.</td>
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
