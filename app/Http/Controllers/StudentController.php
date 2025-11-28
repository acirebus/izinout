<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Permission;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * dashboard siswa
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $student = $user->student;
        
    // statistik izin siswa
        $stats = [
            'total_requests' => $student->permissions()->count(),
            'approved_requests' => $student->permissions()->where('status', 'approved')->count(),
            'pending_requests' => $student->permissions()->where('status', 'submitted')->count(),
            'active_permissions' => $student->permissions()->where('status', 'approved')
                ->where(function($q) {
                    $q->whereNull('time_end')->orWhere('time_end', '>', now());
                })->where('time_start', '<=', now())->count(),
        ];

    // izin terbaru
        $recentRequests = $student->permissions()
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

    // izin aktif
        $activePermissions = $student->permissions()
            ->where('status', 'approved')
            ->where(function($q) {
                $q->whereNull('time_end')->orWhere('time_end', '>', now());
            })
            ->where('time_start', '<=', now())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.dashboard', compact('user', 'student', 'stats', 'recentRequests', 'activePermissions'));
    }

    /**
     * menampilkan daftar izin
     */
    public function permissions(Request $request): View
    {
        $user = Auth::user();
        $student = $user->student;
        $status = $request->get('status', 'all');
        
        $query = $student->permissions()->with(['admin']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $permissions = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('student.permissions', compact('user', 'student', 'permissions', 'status'));
    }

    /**
     * menampilkan form izin baru
     */
    public function createPermission(): View
    {
        $user = Auth::user();
        $student = $user->student;
        
        return view('student.create-permission', compact('user', 'student'));
    }

    /**
     * Store izin baru
     */
    public function storePermission(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $student = $user->student;

        // CEK IZIN AKTIF ATAU DIAJUKAN
        $izinAktif = Permission::where('student_id', $student->student_id)
            ->whereIn('status', ['approved', 'waiting_guru', 'waiting_admin'])
            ->where(function($q) {
                $q->whereNull('time_end')->orWhere('time_end', '>', now());
            })
            ->where('time_start', '<=', now())
            ->first();
        if ($izinAktif) {
            return redirect()->back()->with('error', 'Anda hanya bisa memiliki satu izin aktif/diajukan pada satu waktu.');
        }

        $request->validate([
            'reason' => 'required|string|max:500',
            'time_start' => 'required|date_format:Y-m-d\TH:i',
            'time_end' => 'nullable|date_format:Y-m-d\TH:i|after:time_start',
            'evidence' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'reason.required' => 'Reason is required.',
            'time_start.required' => 'Start time is required.',
            'time_end.after' => 'End time must be after start time.',
            'evidence.mimes' => 'Evidence file must be PDF, JPG, JPEG, or PNG format.',
            'evidence.max' => 'Evidence file size maximum 2MB.',
        ]);

        // Set waktu akhir otomatis jika tidak diisi
        $timeEnd = $request->time_end;
        if (!$timeEnd && $request->time_start) {
            $start = \Carbon\Carbon::parse($request->time_start);
            $timeEnd = $start->copy()->setTime(20, 0, 0);
        }

        $data = [
            'student_id' => $student->student_id,
            'school_id' => $user->school_id,
            'reason' => $request->reason,
            'time_start' => $request->time_start,
            'time_end' => $timeEnd,
            'type' => 'temporary',
            'status' => 'waiting_guru',
        ];

        // Handle file upload
        if ($request->hasFile('evidence')) {
            $file = $request->file('evidence');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('evidence', $filename, 'public');
            $data['evidence_path'] = $path;
        }

        $permission = Permission::create($data);

        // notifikasi ke admin sekolah
        $adminUsers = \App\Models\User::where('school_id', $user->school_id)
            ->where('role', 'admin_bk')->get();
        foreach ($adminUsers as $admin) {
            \App\Models\Notification::create([
                'user_id' => $admin->user_id,
                'title' => 'Izin Baru Diajukan',
                'message' => $student->user->name . ' mengajukan izin baru.',
                'channel' => 'in_app',
                'status' => 'unread',
                'created_at' => now(),
            ]);
        }

        // notifikasi ke guru sekolah
        $guruUsers = \App\Models\User::where('school_id', $user->school_id)
            ->where('role', 'guru')->get();
        foreach ($guruUsers as $guru) {
            \App\Models\Notification::create([
                'user_id' => $guru->user_id,
                'title' => 'Izin Baru Diajukan',
                'message' => $student->user->name . ' mengajukan izin baru.',
                'channel' => 'in_app',
                'status' => 'unread',
                'created_at' => now(),
            ]);
        }

        return redirect()->route('student.permissions')->with('success', 'Permission request submitted successfully.');
    }

    /**
     * detail izin
     */
    public function permissionDetail($id): View
    {
        $user = Auth::user();
        $student = $user->student;
        
        $permission = $student->permissions()
            ->with(['admin'])
            ->findOrFail($id);

        return view('student.permission-detail', compact('user', 'student', 'permission'));
    }

    /**
     * profile siswa
     */
    public function profile(): View
    {
        $user = Auth::user();
        $student = $user->student;
        
        return view('student.profile', compact('user', 'student'));
    }

    /**
     * Update profile siswa
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'phone' => 'nullable|string|max:20',
        ]);

        // Update user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        return redirect()->route('student.profile')
            ->with('success', 'Profile updated successfully.');
    }
}