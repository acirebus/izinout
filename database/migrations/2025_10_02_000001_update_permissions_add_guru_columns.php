<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            // Pastikan kolom guru_id dan guru_approved_at sudah ada untuk tracking approval guru
            if (!Schema::hasColumn('permissions', 'guru_id')) {
                $table->unsignedBigInteger('guru_id')->nullable()->after('status');
            }
            if (!Schema::hasColumn('permissions', 'guru_approved_at')) {
                $table->timestamp('guru_approved_at')->nullable()->after('guru_id');
            }
            // Ubah enum status jika perlu
            DB::statement("ALTER TABLE permissions MODIFY COLUMN status ENUM('waiting_guru','submitted','approved','rejected','expired') DEFAULT 'waiting_guru'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            if (Schema::hasColumn('permissions', 'guru_id')) {
                $table->dropColumn('guru_id');
            }
            if (Schema::hasColumn('permissions', 'guru_approved_at')) {
                $table->dropColumn('guru_approved_at');
            }
            // Kembalikan enum status ke sebelumnya jika perlu
            DB::statement("ALTER TABLE permissions MODIFY COLUMN status ENUM('submitted','approved','rejected','expired') DEFAULT 'submitted'");
        });
    }
};
