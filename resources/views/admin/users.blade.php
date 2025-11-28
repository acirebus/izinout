@php($title = 'Kelola Data Pengguna')
@extends('layouts.dashboard')

@section('title', 'IzinOut - Data Pengguna')

@section('dashboard-content')
<div class="px-4 py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Data Pengguna</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow flex items-center">
            <i class="fas fa-user-plus mr-2"></i> Tambah Pengguna
        </a>
    </div>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <span class="text-sm font-medium text-blue-600">{{ substr($user->name ?? '', 0, 2) }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                @if($user->role === 'student' && $user->student)
                                    <div class="text-xs text-gray-500">NIS: {{ $user->student->student_number ?? '-' }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                        <div class="text-xs text-gray-500">{{ $user->phone ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap capitalize">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            @if($user->role === 'admin_bk') bg-blue-100 text-blue-800
                            @elseif($user->role === 'guru') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800 @endif">
                            @if($user->role === 'admin_bk')
                                Admin BK
                            @elseif($user->role === 'guru')
                                Guru
                            @else
                                Siswa
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('admin.users.show', $user->user_id) }}" class="text-blue-600 hover:underline mr-2" title="Detail"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.users.edit', $user->user_id) }}" class="text-yellow-600 hover:underline mr-2" title="Edit"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.users.destroy', $user->user_id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline" title="Hapus"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">Tidak ada data pengguna.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
@endsection
