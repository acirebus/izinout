<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'channel',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'channel' => 'string',
        'status' => 'string',
    ];

    /**
     * mendapatkan user pemilik notifikasi ini
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * menandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead(): void
    {
        $this->update(['status' => 'read']);
    }

    /**
     * cek apakah notifikasi belum dibaca
     */
    public function isUnread(): bool
    {
        return $this->status === 'unread';
    }

    /**
     * mendapatkan tanggal dibuat yang sudah diformat
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * scope query untuk notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    /**
     * scope query untuk notifikasi yang sudah dibaca
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    /**
     * membuat notifikasi untuk perubahan status izin
     */
    public static function createPermissionNotification(int $userId, string $status, int $permissionId): self
    {
        $messages = [
            'approved' => 'Perizinan Anda telah disetujui oleh admin.',
            'rejected' => 'Perizinan Anda telah ditolak oleh admin.',
            'expired' => 'Perizinan Anda telah kedaluwarsa.',
        ];

        $titles = [
            'approved' => 'Perizinan Disetujui',
            'rejected' => 'Perizinan Ditolak',
            'expired' => 'Perizinan Kedaluwarsa',
        ];

        return self::create([
            'user_id' => $userId,
            'title' => $titles[$status] ?? 'Update Perizinan',
            'message' => $messages[$status] ?? 'Status perizinan Anda telah diperbarui.',
            'channel' => 'in_app',
        ]);
    }
}