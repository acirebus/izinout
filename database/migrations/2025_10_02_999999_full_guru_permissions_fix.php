<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Pastikan kolom status pada permissions sudah support semua status yang dibutuhkan
        DB::statement("ALTER TABLE permissions MODIFY COLUMN status ENUM('waiting_guru','submitted','approved','rejected','expired') DEFAULT 'waiting_guru'");

        // 2. Tambahkan kolom guru_id dan guru_approved_at jika belum ada
        Schema::table('permissions', function (Blueprint $table) {
            if (!Schema::hasColumn('permissions', 'guru_id')) {
                $table->unsignedBigInteger('guru_id')->nullable()->after('status');
            }
            if (!Schema::hasColumn('permissions', 'guru_approved_at')) {
                $table->timestamp('guru_approved_at')->nullable()->after('guru_id');
            }
        });

        // 3. Pastikan kolom role pada users sudah support 'guru'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin_bk','guru','student') NOT NULL");
    }

    public function down(): void
    {
        // 1. Kembalikan enum status ke default lama
        DB::statement("ALTER TABLE permissions MODIFY COLUMN status ENUM('submitted','approved','rejected','expired') DEFAULT 'submitted'");

        // 2. Hapus kolom guru_id dan guru_approved_at jika ada
        Schema::table('permissions', function (Blueprint $table) {
            if (Schema::hasColumn('permissions', 'guru_id')) {
                $table->dropColumn('guru_id');
            }
            if (Schema::hasColumn('permissions', 'guru_approved_at')) {
                $table->dropColumn('guru_approved_at');
            }
        });

        // 3. Kembalikan enum role pada users ke default lama
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin_bk','student') NOT NULL");
    }
};
