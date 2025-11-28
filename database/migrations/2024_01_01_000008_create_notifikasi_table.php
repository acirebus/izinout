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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->enum('channel', ['in_app', 'push'])->default('in_app');
            $table->enum('status', ['unread', 'read'])->default('unread');
            $table->timestamp('created_at')->useCurrent();
            $table->index('user_id', 'idx_notifications_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};