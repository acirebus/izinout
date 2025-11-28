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
        Schema::create('permission_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->foreignId('permission_id')->constrained('permissions', 'permission_id')->onDelete('cascade');
            $table->foreignId('actor_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->enum('action', ['submitted', 'approved', 'rejected', 'expired', 'scanned', 'qr_generated']);
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->index('permission_id', 'idx_permission_logs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_logs');
    }
};