<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\School;
use App\Models\User;
use App\Models\Student;
use App\Models\Permission;
use App\Models\PermissionLog;
use App\Models\QrPass;
use App\Models\Notification;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // === sekula ===
        $school = School::create([
            'name' => 'SMK Negeri 13 Bandung',
            'unique_code' => 'SMKN13BDG',
            'address' => 'Jl. Soekarno Hatta No.KM. 10, Jatisari, Kec. Buahbatu, Kota Bandung, Jawa Barat',
        ]);

        // === pengguna ===
        $admin = User::create([
            'email' => 'adminbk@smkn13bdg',
            'password_hash' => Hash::make('password'),
            'name' => 'Admin BK',
            'phone' => '081234567890',
            'role' => 'admin',
            'school_id' => $school->school_id,
            'status' => 'active',
        ]);

        $guru = User::create([
            'email' => 'gurubk@smkn13bdg',
            'password_hash' => Hash::make('password'),
            'name' => 'Guru BK',
            'phone' => '081234567892',
            'role' => 'guru',
            'school_id' => $school->school_id,
            'status' => 'active',
        ]);

        $studentUser = User::create([
            'email' => 'ahmad@smkn13bdg',
            'password_hash' => Hash::make('password'),
            'name' => 'Ahmad Siswa',
            'phone' => '081234567891',
            'role' => 'student',
            'school_id' => $school->school_id,
            'status' => 'active',
        ]);

        // === Siswa ===
        $student = Student::create([
            'user_id' => $studentUser->user_id,
            'student_number' => '01',
            'class_name' => 'XII-RPL2',
        ]);

        // === Izin sampel/contoh ===
        $permission = Permission::create([
            'student_id' => $student->student_id,
            'school_id' => $school->school_id,
            'reason' => 'Izin Demo',
            'time_start' => now()->addHour()->format('Y-m-d H:i:s'),
            'time_end' => now()->addHours(3)->format('Y-m-d H:i:s'),
            'type' => 'temporary',
            'status' => 'submitted',
            'guru_id' => $guru->user_id,
            'admin_id' => $admin->user_id,
            'created_at' => now()->subMinutes(45)->format('Y-m-d H:i:s'),
        ]);

        // === log ===
        PermissionLog::createLog($permission->permission_id, $studentUser->user_id, 'submitted', 'Perizinan diajukan siswa');

        // === ntf ===
        Notification::create([
            'user_id' => $guru->user_id,
            'title' => 'Perizinan Baru',
            'message' => 'Ada perizinan baru yang menunggu persetujuan Anda sebagai guru.',
            'channel' => 'in_app',
        ]);

        // === qr & ntf siswa ===
        if ($permission->status === 'approved') {
            $token = hash('sha256', uniqid($permission->permission_id, true));
            $expiresAt = $permission->time_end ?? now()->endOfDay();
            QrPass::create([
                'permission_id' => $permission->permission_id,
                'token' => $token,
                'status' => 'active',
                'expires_at' => $expiresAt,
            ]);
            PermissionLog::createLog($permission->permission_id, $admin->user_id, 'approved', 'Perizinan disetujui oleh admin');
            PermissionLog::createLog($permission->permission_id, $admin->user_id, 'qr_generated', 'QR Code berhasil dibuat');
            Notification::createPermissionNotification(
                $studentUser->user_id,
                $permission->status,
                $permission->permission_id
            );
        }

        Notification::create([
            'user_id' => $admin->user_id,
            'title' => 'Perizinan Baru',
            'message' => 'Ada perizinan baru yang menunggu persetujuan Anda.',
            'channel' => 'in_app',
        ]);
    }
}