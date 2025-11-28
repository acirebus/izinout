@php($title = 'Riwayat Perizinan')
@php($activeTab = 'permissions')
@extends('layouts.dashboard')

@section('title', 'IzinOut - Riwayat Perizinan')

@section('dashboard-content')

<!-- riwayat izin -->
<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Riwayat Perizinan</h1>
                    <p class="mt-2 text-gray-600">Lihat semua perizinan yang pernah Anda ajukan</p>
                </div>
                <div class="mt-4 sm:mt-0 flex space-x-3">
                    @if($user->status === 'active')
                    <a href="{{ route('student.permission.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Ajukan Perizinan
                    </a>
                    @else
                    <span class="inline-flex items-center px-4 py-2 border border-red-200 bg-red-50 rounded-md text-sm font-medium text-red-700 cursor-not-allowed">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-12.728 12.728M5.636 5.636l12.728 12.728"></path>
                        </svg>
                        Akun nonaktif/diblokir
                    </span>
                    @endif
                    <a href="{{ route('student.dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- filter izin-->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <a href="{{ route('student.permissions', ['status' => 'all']) }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ $status === 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Semua
                        <span class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $status === 'all' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-900' }}">
                            {{ $student->permissions()->count() }}
                        </span>
                    </a>
                    <a href="{{ route('student.permissions', ['status' => 'submitted']) }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ $status === 'submitted' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Pending
                        <span class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $status === 'submitted' ? 'bg-yellow-100 text-yellow-600' : 'bg-gray-100 text-gray-900' }}">
                            {{ $student->permissions()->where('status', 'submitted')->count() }}
                        </span>
                    </a>
                    <a href="{{ route('student.permissions', ['status' => 'approved']) }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ $status === 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Approved
                        <span class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $status === 'approved' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-900' }}">
                            {{ $student->permissions()->where('status', 'approved')->count() }}
                        </span>
                    </a>
                    <a href="{{ route('student.permissions', ['status' => 'rejected']) }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ $status === 'rejected' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Rejected
                        <span class="ml-2 py-0.5 px-2 rounded-full text-xs {{ $status === 'rejected' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-900' }}">
                            {{ $student->permissions()->where('status', 'rejected')->count() }}
                        </span>
                    </a>
                </nav>
            </div>
        </div>

        @if($permissions->count() > 0)
            <div class="space-y-4">
                @foreach($permissions as $permission)
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-3 mb-3">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $permission->status === 'approved' ? 'bg-green-100 text-green-800' : ($permission->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($permission->status) }}
                                        </span>
                                        @if($permission->status === 'approved')
                                            @if($permission->time_end && now() > $permission->time_end)
                                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                                    Expired
                                                </span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-600">
                                                    Active
                                                </span>
                                            @endif
                                        @endif
                                        <span class="text-sm text-gray-500">
                                            #{{ $permission->permission_id }}
                                        </span>
                                    </div>
                                    
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                                        {{ Str::limit($permission->alasan, 100) }}
                                    </h3>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600">
                                        <div>
                                            <span class="font-medium">Start Time:</span>
                                            <div>{{ $permission->time_start->format('d M Y, H:i') }}</div>
                                        </div>
                                        <div>
                                            <span class="font-medium">End Time:</span>
                                            <div>{{ $permission->time_end ? $permission->time_end->format('d M Y, H:i') : 'Not specified' }}</div>
                                        </div>
                                        <div>
                                            <span class="font-medium">Submitted:</span>
                                            <div>{{ $permission->created_at->format('d M Y, H:i') }}</div>
                                        </div>
                                        @if($permission->approved_at)
                                            <div>
                                                <span class="font-medium">Processed:</span>
                                                <div>{{ $permission->approved_at->format('d M Y, H:i') }}</div>
                                            </div>
                                        @endif
                                    </div>

                                    @if($permission->admin_notes)
                                        <div class="mt-3 p-3 bg-gray-50 rounded-md">
                                            <span class="text-sm font-medium text-gray-700">Admin Notes:</span>
                                            <p class="text-sm text-gray-600 mt-1">{{ $permission->admin_notes }}</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex-shrink-0 ml-4">
                                    @if(isset($permission) && isset($permission->permission_id))
                                        <a href="{{ route('student.permission.detail', ['id' => $permission->permission_id]) }}" 
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Detail
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $permissions->appends(request()->query())->links() }}
            </div>
        @else
            <div class="bg-white shadow-sm rounded-lg border border-gray-200">
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-4 text-sm font-medium text-gray-900">Belum ada perizinan</h3>
                    <p class="mt-2 text-sm text-gray-500">
                        @if($status === 'all')
                            Anda belum pernah mengajukan perizinan.
                        @else
                            Tidak ada perizinan dengan status "{{ $status }}".
                        @endif
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('student.permission.create') }}" 
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Ajukan Perizinan Pertama
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection