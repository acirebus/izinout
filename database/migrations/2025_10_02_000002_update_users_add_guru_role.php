<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan 'guru' ke enum role pada tabel users
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin_bk','guru','student') NOT NULL");
    }

    public function down(): void
    {
        // Kembalikan ke enum sebelumnya jika perlu
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin_bk','student') NOT NULL");
    }
};
