<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id('permission_id');
            $table->foreignId('student_id')->constrained('students', 'student_id')->onDelete('cascade');
            $table->foreignId('school_id')->constrained('schools', 'school_id')->onDelete('restrict');
            $table->text('reason');
            $table->string('evidence_path', 512)->nullable();
            $table->dateTime('time_start');
            $table->dateTime('time_end')->nullable();
            $table->enum('type', ['temporary', 'leave'])->default('temporary');
            $table->enum('status', ['waiting_guru', 'submitted', 'approved', 'rejected', 'expired'])->default('waiting_guru');
            $table->foreignId('guru_id')->nullable()->constrained('users', 'user_id')->onDelete('set null');
            $table->timestamp('guru_approved_at')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users', 'user_id')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->index('student_id', 'idx_permissions_student');
            $table->index('school_id', 'idx_permissions_school');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};