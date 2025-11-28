<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermissionLog extends Model
{
    protected $table = 'permission_logs';
    protected $primaryKey = 'log_id';
    public $timestamps = false;

    protected $fillable = [
        'permission_id',
        'actor_id',
        'action',
        'note',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'action' => 'string',
    ];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id', 'permission_id');
    }


    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id', 'user_id');
    }

    /**
     * membuat entri log baru
     */
    public static function createLog(int $permissionId, int $actorId, string $action, ?string $note = null): self
    {
        return self::create([
            'permission_id' => $permissionId,
            'actor_id' => $actorId,
            'action' => $action,
            'note' => $note,
        ]);
    }


    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i:s');
    }


    public function getActionLabelAttribute(): string
    {
        $labels = [
            'submitted' => 'Diajukan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'expired' => 'Kedaluwarsa',
            'scanned' => 'QR Code Dipindai',
            'qr_generated' => 'QR Code Dibuat',
        ];

        return $labels[$this->action] ?? $this->action;
    }
}