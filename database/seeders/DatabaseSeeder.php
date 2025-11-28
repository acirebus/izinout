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

        $studentUsers = [
            [
                'email' => 'ahmad@smkn13bdg',
                'name' => 'Ahmad Siswa',
                'phone' => '081234567891',
                'student_number' => '1001',
                'class_name' => 'XII-RPL2',
            ],
            [
                'email' => 'udin@smkn13bdg',
                'name' => 'Udin Siswa',
                'phone' => '081234567892',
                'student_number' => '1002',
                'class_name' => 'XII-RPL2',
            ],
            [
                'email' => 'asep@smkn13bdg',
                'name' => 'Asep Siswa',
                'phone' => '081234567893',
                'student_number' => '1003',
                'class_name' => 'XII-RPL2',
            ],
            [
                'email' => 'agus@smkn13bdg',
                'name' => 'Agus Siswa',
                'phone' => '081234567894',
                'student_number' => '1004',
                'class_name' => 'XII-RPL2',
            ],
            [
                'email' => 'tessiswa@smkn13bdg',
                'name' => 'Tes Siswa',
                'phone' => '081234567895',
                'student_number' => '1005',
                'class_name' => 'XII-RPL2',
            ],
        ];

        $students = [];
        foreach ($studentUsers as $s) {
            $user = User::create([
                'email' => $s['email'],
                'password_hash' => Hash::make('password'),
                'name' => $s['name'],
                'phone' => $s['phone'],
                'role' => 'student',
                'school_id' => $school->school_id,
                'status' => 'active',
            ]);
            $student = Student::create([
                'user_id' => $user->user_id,
                'student_number' => $s['student_number'],
                'class_name' => $s['class_name'],
            ]);
            $students[] = $student;
        }

        // === Izin sampel/contoh untuk siswa pertama ===
        $sampleStudent = $students[0];
        $sampleUserId = $sampleStudent->user_id;
        $permission = Permission::create([
            'student_id' => $sampleStudent->student_id,
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
        PermissionLog::createLog($permission->permission_id, $sampleUserId, 'submitted', 'Perizinan diajukan siswa');

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
                $sampleUserId,
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