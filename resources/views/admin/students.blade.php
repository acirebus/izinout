@php($title = 'Data Siswa')
@extends('layouts.dashboard')

@section('title', 'IzinOut - Kelola Siswa')

@section('dashboard-content')
<div class="px-4 py-6">
        <div class="mb-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Kelola Siswa</h1>
                    <p class="mt-2 text-gray-600">Daftar semua siswa di sekolah Anda</p>
                </div>
                
            </div>
        </div>

        <div class="mb-6">
            <form method="GET" action="{{ route('admin.students') }}" class="max-w-md">
                <div class="relative">
                    <input type="text" 
                           name="search" 
                           value="{{ $search }}"
                           placeholder="Cari berdasarkan nama, nomor induk"
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Siswa</h2>
                <p class="text-sm text-gray-600">Total: {{ $students->total() }} siswa</p>
            </div>

            @if($students->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Perizinan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($students as $student)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-blue-600">
                                                        {{ substr($student->user->name ?? '', 0, 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $student->user->name ?? '' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $student->student_number ?? 'Belum diatur' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $student->class_name ?? '' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $student->user->email ?? '' }}</div>
                                        <div class="text-sm text-gray-500">{{ $student->user->phone ?? 'Tidak ada' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $student->user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($student->user->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">{{ $student->permissions->count() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $students->appends(request()->query())->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-sm font-medium text-gray-900">Tidak ada siswa ditemukan</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        @if($search)
                            Tidak ada siswa yang cocok dengan pencarian "{{ $search }}".
                        @else
                            Belum ada siswa yang terdaftar.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection