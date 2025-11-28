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
        Schema::create('warnings', function (Blueprint $table) {
            $table->id('warning_id');
            $table->foreignId('student_id')->constrained('students', 'student_id')->onDelete('cascade');
            $table->foreignId('permission_id')->nullable()->constrained('permissions', 'permission_id')->onDelete('set null');
            $table->text('reason')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index('student_id', 'idx_warnings_student');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warnings');
    }
};