@extends('layouts.dashboard')

@section('dashboard-content')
@section('title', 'IzinOut - Dashboard Siswa')
@if($activePermissions->count() > 0)
<div class="card mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-lg font-semibold text-gray-900 flex items-center">
            <i class="fas fa-play-circle text-green-500 mr-2"></i>
            Izin Aktif Saat Ini
        </h2>
    </div>
    <div class="p-6">
        <div class="grid gap-4">
            @foreach($activePermissions as $permission)
                <div class="border border-green-200 bg-green-50 rounded-lg p-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <span class="badge-success">Aktif</span>
                                @if($permission->qr_code)
                                    <span class="badge-info ml-2">QR Tersedia</span>
                                @endif
                            </div>
                            <p class="font-medium text-gray-900 mb-1">{{ $permission->reason }}</p>
                            <div class="text-sm text-gray-600">
                                <p class="flex items-center mb-1">
                                    <i class="fas fa-clock mr-2 w-4"></i>
                                    {{ $permission->formatted_time_start }}
                                    @if($permission->time_end)
                                        - {{ $permission->formatted_time_end }}
                                    @else
                                        (Tidak terbatas)
                                    @endif
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-calendar mr-2 w-4"></i>
                                    Disetujui: {{ $permission->formatted_created_at }}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col space-y-2 ml-4">
                            @if($permission->qr_code)
                                <button onclick="showQRCode({{ $permission->id }})" 
                                        class="btn-primary text-xs px-3 py-1">
                                    <i class="fas fa-qrcode mr-1"></i>QR Code
                                </button>
                            @endif
                            @if(isset($permission) && isset($permission->id))
                                <a href="{{ route('student.permission.detail', $permission->id) }}" 
                                   class="btn-secondary text-xs px-3 py-1 text-center">
                                    Detail
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- aksi cepat -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="space-y-3">
            @if($user->status === 'active')
            <a href="{{ route('student.permission.create') }}" 
               class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                <i class="fas fa-plus-circle text-blue-600 mr-3"></i>
                <span class="text-gray-900 font-medium">Ajukan Izin Baru</span>
            </a>
            <!-- pesan jika akun diblokir -->
            @else
            <div class="flex items-center p-3 bg-red-50 border border-red-200 rounded-lg">
                <i class="fas fa-ban text-red-600 mr-3"></i>
                <span class="text-red-700 font-medium">Akun Anda nonaktif/diblokir. Tidak dapat mengajukan izin baru.</span>
            </div>
            @endif
            
            <a href="{{ route('student.permissions') }}" 
               class="flex items-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors">
                <i class="fas fa-list-alt text-gray-600 mr-3"></i>
                <span class="text-gray-900 font-medium">Lihat Riwayat Izin</span>
            </a>
        </div>
    </div>

    <div class="card p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Siswa</h3>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-600">Nama:</span>
                <span class="font-medium">{{ $student->user->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">NIS:</span>
                <span class="font-medium">{{ $student->student_number }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Kelas:</span>
                <span class="font-medium">{{ $student->class_name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Sekolah:</span>
                <span class="font-medium text-blue-600 text-sm">{{ $student->user->school->name }}</span>
            </div>
        </div>
        
    </div>
</div>

<!-- izin terbaru (siswa) -->
<div class="card">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-900">Pengajuan Terbaru</h2>
            <a href="{{ route('student.permissions') }}" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                Lihat Semua
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Izin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diajukan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($recentRequests as $permission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="max-w-xs">
                                <p class="text-sm text-gray-900 truncate">{{ $permission->reason }}</p>
                                @if($permission->evidence_url)
                                    <p class="text-xs text-blue-600 mt-1">
                                        <i class="fas fa-paperclip mr-1"></i>Ada lampiran
                                    </p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div>
                                <p>{{ $permission->formatted_time_start }}</p>
                                @if($permission->time_end)
                                    <p class="text-xs">s/d {{ $permission->formatted_time_end }}</p>
                                @else
                                    <p class="text-xs text-blue-600">Tidak terbatas</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-1">
                                @if($permission->status === 'waiting_guru')
                                    <span class="badge-info">Menunggu Persetujuan Guru</span>
                                @elseif($permission->status === 'submitted')
                                    <span class="badge-warning">Menunggu Admin</span>
                                @elseif($permission->status === 'approved')
                                    <span class="badge-success">Disetujui</span>
                                    @php $activeStatus = $permission->getActiveStatus(); @endphp
                                    @if($activeStatus === 'active')
                                        <span class="badge-info">Aktif</span>
                                    @elseif($activeStatus === 'expired')
                                        <span class="badge-danger">Expired</span>
                                    @endif
                                @elseif($permission->status === 'rejected')
                                    <span class="badge-danger">Ditolak</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $permission->formatted_created_at }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('student.permission.detail', $permission->permission_id ?? $permission->id) }}" 
                               class="text-blue-600 hover:text-blue-700">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-gray-300 text-3xl mb-3"></i>
                                <p class="text-gray-500 mb-4">Belum ada pengajuan izin</p>
                                <a href="{{ route('student.permission.create') }}" class="btn-primary">
                                    <i class="fas fa-plus mr-2"></i>Ajukan Izin Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- QR -->
<div id="qrModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" onclick="closeQRModal()">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg max-w-sm w-full" onclick="event.stopPropagation()">
            <div class="p-6 text-center">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">QR Code Izin</h3>
                <div id="qrCodeContainer" class="mb-4">
                    <!-- QR magical spell shall be casted here -->
                </div>
                <p class="text-sm text-gray-600 mb-4">Tunjukkan QR Code ini kepada petugas untuk verifikasi</p>
                <button onclick="closeQRModal()" class="btn-primary">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@php
    $title = 'Dashboard Siswa';
    $activeTab = 'dashboard';
@endphp

@push('scripts')
<script>
function showQRCode(permissionId) {
    const qrContainer = document.getElementById('qrCodeContainer');
    qrContainer.innerHTML = '<div class="flex justify-center"><i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i></div>';
    
    // membuat elemen gambar untuk qr code
    const img = document.createElement('div');
    img.innerHTML = <img src="/qr/${permissionId}" alt="QR Code" class="mx-auto" style="width: 250px; height: 250px;">;
    
    qrContainer.innerHTML = '';
    qrContainer.appendChild(img);
    
    document.getElementById('qrModal').classList.remove('hidden');
}

function closeQRModal() {
    document.getElementById('qrModal').classList.add('hidden');
}
</script>
@endpush