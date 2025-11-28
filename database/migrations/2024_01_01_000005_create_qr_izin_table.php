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
        Schema::create('qr_passes', function (Blueprint $table) {
            $table->id('qr_id');
            $table->foreignId('permission_id')->unique()->constrained('permissions', 'permission_id')->onDelete('cascade');
            $table->string('token')->unique();
            $table->enum('status', ['active', 'used', 'expired'])->default('active');
            $table->timestamp('generated_at')->useCurrent();
            $table->timestamp('expires_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_passes');
    }
};