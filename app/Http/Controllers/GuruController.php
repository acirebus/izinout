<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class GuruController extends Controller
{
    /**
     * Halaman detail izin untuk guru
     */
    public function permissionDetail($id): View
    {
        $user = Auth::user();
        $permission = Permission::with(['student.user'])->findOrFail($id);
        return view('guru.permission-detail', compact('user', 'permission'));
    }

    
    /**
     * Menampilkan riwayat izin semua siswa untuk guru
     */
    public function riwayatIzin(Request $request): View
    {
        $user = Auth::user();
        $search = $request->get('search');
        $query = Permission::with(['student.user']);
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
        $permissions = $query->orderBy('created_at', 'desc')->paginate(15);
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->take(20)->get();
        return view('guru.riwayat-izin', compact('user', 'permissions', 'search', 'notifications'));
    }
    public function profile(): View
    {
        $user = Auth::user();
        return view('guru.profile', compact('user'));
    }

    /**
     * Memperbarui profil guru
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
        return redirect()->route('guru.profile')->with('success', 'Profil berhasil diperbarui.');
    }
    /**
     * Dashboard guru: daftar izin yang perlu di-approve
     */
    public function dashboard(Request $request): View
    {
        $user = Auth::user();
        $search = $request->get('search');
        $query = Permission::with(['student.user'])
            ->where('status', 'waiting_guru');
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
        $permissions = $query->orderBy('created_at', 'desc')->paginate(15);

        // Statistik untuk ringkasan data
        $stats = [
            'total_students' => \App\Models\User::where('role', 'student')->count(),
            'pending_requests' => Permission::where('status', 'waiting_guru')->count(),
            'active_permissions' => Permission::where('status', 'approved')->where(function($q){
                $q->whereNull('time_end')
                  ->orWhere('time_end', '>=', now());
            })->count(),
            'total_requests_today' => Permission::whereDate('created_at', now()->toDateString())->count(),
        ];

        $notifications = $user->notifications()->orderBy('created_at', 'desc')->take(20)->get();
        return view('guru.dashboard', compact('user', 'permissions', 'search', 'stats', 'notifications'));
    }

    /**
     * Approve izin oleh guru
     */
    public function approve(Request $request, $id): RedirectResponse
    {
        $user = Auth::user();
        $permission = Permission::where('status', 'waiting_guru')->findOrFail($id);
        $permission->update([
            'status' => 'submitted',
            'guru_id' => $user->user_id,
            'guru_approved_at' => now(),
        ]);
        // Notifikasi ke admin bisa ditambahkan di sini
        return redirect()->route('guru.dashboard')->with('success', 'Izin berhasil di-approve dan diteruskan ke admin.');
    }

    /**
     * Tolak izin oleh guru
     */
    public function reject(Request $request, $id): RedirectResponse
    {
        $user = Auth::user();
        $permission = Permission::where('status', 'waiting_guru')->findOrFail($id);
        $permission->update([
            'status' => 'rejected',
            'guru_id' => $user->user_id,
            'guru_approved_at' => now(),
        ]);
        // Notifikasi ke siswa bisa ditambahkan di sini
        return redirect()->route('guru.dashboard')->with('success', 'Izin berhasil ditolak.');
    }


    }
