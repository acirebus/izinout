@extends('layouts.dashboard')

@section('dashboard-content')
@section('title', 'IzinOut - Kelola Perizinan')
<!-- Filters -->
<div class="card p-6 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
    <div class="flex flex-wrap items-center space-x-2">
            <a href="{{ route('admin.permissions', ['status' => 'all']) }}" 
               class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $status === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Semua ({{ $totalPermissions }})
            </a>
            <a href="{{ route('admin.permissions', ['status' => 'submitted']) }}" 
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $status === 'submitted' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Pending
            </a>
            <a href="{{ route('admin.permissions', ['status' => 'approved']) }}" 
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $status === 'approved' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Approved
            </a>
            <a href="{{ route('admin.permissions', ['status' => 'rejected']) }}" 
                class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $status === 'rejected' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                Rejected
            </a>
            <form method="GET" action="{{ route('admin.permissions') }}" class="inline-block ml-2">
                <select name="class_name" onchange="this.form.submit()" class="px-3 py-2 rounded-lg border border-gray-300 text-sm">
                    <option value="">Semua Kelas</option>
                    @foreach($classList as $class)
                        <option value="{{ $class }}" {{ request('class_name') == $class ? 'selected' : '' }}>{{ $class }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="status" value="{{ $status }}">
                <input type="hidden" name="search" value="{{ request('search') }}">
            </form>
            <button type="button" id="exportSelectedExcelBtn" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition ml-2">
                <i class="fas fa-file-excel mr-2"></i> Export Excel
            </button>
        </div>
        
        <div class="flex items-center space-x-3">
            <form method="GET" action="{{ route('admin.permissions') }}" class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                <input type="text" 
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari siswa, kelas, atau alasan..."
                       class="pl-10 input-field"
                       style="width: 250px;">
                <input type="hidden" name="status" value="{{ $status }}">
            </form>
        </div>
    </div>
</div>

<!-- Permissions Table -->
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-center">
                        <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)">
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alasan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Izin</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diajukan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($permissions as $permission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 text-center">
                            <input type="checkbox" class="rowCheckbox" value="{{ $permission->permission_id }}">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600"></i>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">{{ $permission->student->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $permission->student->student_number }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $permission->student->class_name }}
                        </td>
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
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.permission.detail', $permission->permission_id) }}" 
                                   class="text-blue-600 hover:text-blue-700">
                                    Detail
                                </a>
                                
                                <form action="{{ route('admin.permission.destroy', $permission->permission_id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data perizinan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700 ml-2" title="Hapus">
                                     Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-gray-300 text-3xl mb-3"></i>
                                <p class="text-gray-500">
                                    @if($status === 'all')
                                        Belum ada perizinan
                                    @else
                                        Tidak ada perizinan dengan status {{ $status }}
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Tombol aksi untuk data terpilih -->
    <div class="flex items-center space-x-3 mt-4">
        <button type="button" class="btn-danger" onclick="bulkDelete()">
            <i class="fas fa-trash mr-2"></i>Hapus Terpilih
        </button>
    </div>
    @if($permissions->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $permissions->links() }}
        </div>
    @endif
</div>

<!-- Approval Modal -->
<div id="approvalModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" onclick="closeModal('approvalModal')">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg max-w-md w-full" onclick="event.stopPropagation()">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Setujui Permission</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menyetujui permission dari <span id="approvalStudentName" class="font-semibold"></span>?</p>
                
                <form id="approvalForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="approved">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Catatan (Opsional)</label>
                        <textarea name="admin_notes" 
                                  class="input-field" 
                                  rows="3" 
                                  placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="closeModal('approvalModal')"
                                class="btn-secondary">
                            Batal
                        </button>
                        <button type="submit" class="btn-success">
                            <i class="fas fa-check mr-2"></i>Approve
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div id="rejectionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" onclick="closeModal('rejectionModal')">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white rounded-lg max-w-md w-full" onclick="event.stopPropagation()">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tolak Permission</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menolak permission dari <span id="rejectionStudentName" class="font-semibold"></span>?</p>
                
                <form id="rejectionForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="rejected">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                        <textarea name="admin_notes" 
                                  class="input-field" 
                                  rows="3" 
                                  placeholder="Jelaskan alasan penolakan..."
                                  required></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="closeModal('rejectionModal')"
                                class="btn-secondary">
                            Batal
                        </button>
                        <button type="submit" class="btn-danger">
                            <i class="fas fa-times mr-2"></i>Reject
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@php
    $title = 'Kelola Perizinan';
    $activeTab = 'permissions';
@endphp

@push('scripts')
<script>
function openApprovalModal(permissionId, studentName) {
    document.getElementById('approvalStudentName').textContent = studentName;
    document.getElementById('approvalForm').action = `/admin/permissions/${permissionId}/status`;
    document.getElementById('approvalModal').classList.remove('hidden');
}

function openRejectionModal(permissionId, studentName) {
    document.getElementById('rejectionStudentName').textContent = studentName;
    document.getElementById('rejectionForm').action = `/admin/permissions/${permissionId}/status`;
    document.getElementById('rejectionModal').classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

// Checkbox logic
function toggleSelectAll(source) {
    const checkboxes = document.querySelectorAll('.rowCheckbox');
    checkboxes.forEach(cb => cb.checked = source.checked);
}

function getSelectedIds() {
    return Array.from(document.querySelectorAll('.rowCheckbox:checked')).map(cb => cb.value);
}

function bulkDelete() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        alert('Pilih data yang ingin dihapus.');
        return;
    }
    if (!confirm('Yakin ingin menghapus data terpilih?')) return;
    // Kirim ke backend (implementasi endpoint bulk delete diperlukan)
    fetch('/admin/permissions/bulk-delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ ids })
    }).then(res => {
        if (res.ok) location.reload();
        else alert('Gagal menghapus data!');
    });
}

document.getElementById('exportSelectedExcelBtn').onclick = function() {
    const ids = getSelectedIds();
    if (ids.length === 0) {
        alert('Pilih data yang ingin diekspor.');
        return;
    }
    window.location.href = `/admin/permissions/export/excel-selected?ids=${ids.join(',')}`;
};
</script>
@endpush