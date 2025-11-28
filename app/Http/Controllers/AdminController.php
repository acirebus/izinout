<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\Student;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    /**
     * bulk delete izin berdasarkan array ID yang dipilih
     */
    public function bulkDeletePermissions(Request $request)
    {
        $user = Auth::user();
        $ids = $request->input('ids', []);
        if (!is_array($ids) || empty($ids)) {
            return response()->json(['error' => 'Tidak ada data dipilih'], 400);
        }
        $deleted = Permission::whereIn('permission_id', $ids)
            ->whereHas('student.user', function($q) use ($user) {
                $q->where('school_id', $user->school_id);
            })->delete();
        return response()->json(['success' => true, 'deleted' => $deleted]);
    }

    /**
     * export Excel berdasarkan ID terpilih
     */
    public function exportSelectedPermissions(Request $request)
    {
        $ids = $request->input('ids');
        if (!$ids) {
            return redirect()->back()->with('error', 'Tidak ada data dipilih');
        }
        $idArray = explode(',', $ids);
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\PermissionsExport(null, null, null, $idArray),
            'data_perizinan_terpilih.xlsx' //nama file ekspor dan jenisnya
        );
    }

    /**
     * menampilkan data pengguna
     */
    public function users(Request $request): View
    {
        $user = Auth::user();
        $search = $request->get('search');
        $query = User::query();
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $query->where('school_id', $user->school_id);
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users', compact('user', 'users', 'search') + ['activeTab' => 'users']);
    }
    /**
     * menampilkan dashboard admin
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $school = $user->school ?? null;

    // mengambil statistik
        $stats = [
            'total_students' => Student::whereHas('user', function($query) use ($user) {
                $query->where('school_id', $user->user_id);
            })->count(),
            'pending_requests' => Permission::whereHas('student.user', function($query) use ($user) {
                $query->where('school_id', $user->school_id);
            })->where('status', 'submitted')->count(),
            'active_permissions' => Permission::whereHas('student.user', function($query) use ($user) {
                $query->where('school_id', $user->school_id);
            })->where('status', 'approved')->where(function($q) {
                $q->whereNull('time_end')->orWhere('time_end', '>', now());
            })->count(),
            'total_requests_today' => Permission::whereHas('student.user', function($query) use ($user) {
                $query->where('school_id', $user->school_id);
            })->whereDate('created_at', today())->count(),
        ];

    // mengambil permintaan perizinan terbaru
        $recentRequests = Permission::with(['student.user'])
            ->whereHas('student.user', function($query) use ($user) {
                $query->where('school_id', $user->school_id);
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('user', 'school', 'stats', 'recentRequests'));
    }

    /**
     * menampilkan semua data perizinan
     */
    public function permissions(Request $request): View
    {
        $user = Auth::user();
        $status = $request->get('status', 'all');
        $search = $request->get('search');
        $className = $request->get('class_name');

        // Ambil daftar kelas unik
        $classList = \App\Models\Student::whereHas('user', function($q) use ($user) {
            $q->where('school_id', $user->school_id);
        })->distinct()->pluck('class_name')->filter()->values();

        // total semua izin tanpa filter status
        $totalPermissions = Permission::whereHas('student.user', function($q) use ($user) {
            $q->where('school_id', $user->school_id);
        })->count();

        $query = Permission::with(['student.user', 'admin'])
            ->whereHas('student.user', function($q) use ($user) {
                $q->where('school_id', $user->school_id);
            });

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('student.user', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('student', function($subQ) use ($search) {
                    $subQ->where('class_name', 'like', "%{$search}%")
                          ->orWhere('reason', 'like', "%{$search}%");
                });
            });
        }

        if ($className) {
            $query->whereHas('student', function($q) use ($className) {
                $q->where('class_name', $className);
            });
        }

        $permissions = $query->orderBy('created_at', 'desc')->paginate(15);
        // agar parameter search & class_name tetap pada pagination
        $permissions->appends(['search' => $search, 'status' => $status, 'class_name' => $className]);

        return view('admin.permissions', compact('user', 'permissions', 'status', 'totalPermissions', 'search', 'classList'));
    }

    /**
     * menampilkan detail izin
     */
    public function permissionDetail($id): View
    {
        $user = Auth::user();
        
        $permission = Permission::with(['student.user', 'admin'])
            ->whereHas('student.user', function($q) use ($user) {
                $q->where('school_id', $user->school_id);
            })
            ->findOrFail($id);

        return view('admin.permission-detail', compact('user', 'permission'));
    }

    /**
     * memperbarui status izin
     */
    public function updatePermissionStatus(Request $request, $id): RedirectResponse
    {
        $user = Auth::user();
        
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $permission = Permission::whereHas('student.user', function($q) use ($user) {
            $q->where('school_id', $user->school_id);
        })->findOrFail($id);

        if (!in_array($permission->status, ['submitted', 'waiting_guru'])) {
            return redirect()->back()->with('error', 'This permission has already been processed.');
        }

        $permission->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'admin_id' => $user->user_id,
            'approved_at' => now(),
        ]);

        // membuat qr saat izin diterima
        if ($request->status === 'approved') {
            $permission->update([
                'qr_code' => 'QR-' . $permission->permission_id . '-' . time(),
            ]);
        }

        // notifikasi ke siswa
        \App\Models\Notification::createPermissionNotification($permission->student->user_id, $request->status, $permission->permission_id);

        $statusText = $request->status === 'approved' ? 'approved' : 'rejected';
        return redirect()->route('admin.permissions')
            ->with('success', "Permission successfully {$statusText}.");
    }

    /**
     * menampilkan data siswa
     */
    public function students(Request $request): View
    {
        $user = Auth::user();
        $search = $request->get('search');
        
        $query = Student::with(['user'])
            ->whereHas('user', function($q) use ($user) {
                $q->where('school_id', $user->school_id);
            });

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($subQ) use ($search) {
                    $subQ->where('name', 'like', "%{$search}%");
                })
                ->orWhere('student_number', 'like', "%{$search}%")
                ->orWhere('class_name', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(15);

    return view('admin.students', compact('user', 'students', 'search') + ['activeTab' => 'students']);
    }

    /**
     * menampilkan profil oengguna
     */
    public function profile(): View
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'))->with('route', route('admin.profile'));
    }

    /**
     * memperbarui profil pengguna
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only(['name', 'email', 'phone']));

        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * menampilkan form tambah pengguna baru
     */
    public function createUser(): View
    {
        $user = Auth::user();
        return view('admin.user-create', compact('user'));
    }


    public function storeUser(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'role' => 'required|in:admin_bk,student,guru',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
            // Validasi NIS dan kelas jika role student
            'student_number' => 'required_if:role,student|nullable|string|max:50',
            'class_name' => 'required_if:role,student|nullable|string|max:100',
        ]);
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password_hash' => bcrypt($request->password),
            'phone' => $request->phone,
            'status' => $request->status,
            'school_id' => $user->school_id,
        ]);
        // Jika user yang dibuat adalah siswa, buat juga data student
        if ($request->role === 'student') {
            \App\Models\Student::create([
                'user_id' => $newUser->user_id,
                'class_name' => $request->class_name,
                'student_number' => $request->student_number,
            ]);
        }
        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * menampilkan detail pengguna
     */
    public function showUser($id): View
    {
        $user = Auth::user();
        $detail = User::where('school_id', $user->school_id)->findOrFail($id);
        return view('admin.user-show', compact('user', 'detail'));
    }

    /**
     * menampilkan form edit pengguna
     */
    public function editUser($id): View
    {
        $user = Auth::user();
        $edit = User::where('school_id', $user->school_id)->findOrFail($id);
        return view('admin.user-edit', compact('user', 'edit'));
    }

    /**
     * memperbarui data pengguna di database
     */
    public function updateUser(Request $request, $id): RedirectResponse
    {
        $user = Auth::user();
        $edit = User::where('school_id', $user->school_id)->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,{$edit->user_id},user_id",
            'role' => 'required|in:admin_bk,student,guru',
            'phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,banned,pending',
        ]);
        $edit->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);
        if ($request->filled('password')) {
            $edit->update(['password_hash' => bcrypt($request->password)]);
        }
        return redirect()->route('admin.users')->with('success', 'Data pengguna berhasil diupdate.');
    }

    /**
     * menghapus pengguna dari database
     */
    public function destroyUser($id): RedirectResponse
    {
        $user = Auth::user();
        $delete = User::where('school_id', $user->school_id)->findOrFail($id);
        $delete->delete();
        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
    }
    
    /**
     * menghapus data perizinan dari database
     */
    public function destroyPermission($id): \Illuminate\Http\RedirectResponse
    {
        $user = Auth::user();
        $permission = \App\Models\Permission::whereHas('student.user', function($q) use ($user) {
            $q->where('school_id', $user->school_id);
        })->findOrFail($id);
        $permission->delete();
        return redirect()->route('admin.permissions')->with('success', 'Data perizinan berhasil dihapus.');
    }
}