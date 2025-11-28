<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QrPass extends Model
{
    protected $table = 'qr_passes';
    protected $primaryKey = 'qr_id';
    public $timestamps = false;

    protected $fillable = [
        'permission_id',
        'token',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'expires_at' => 'datetime',
        'status' => 'string',
    ];

    /**
     * cek izin yang dimiliki QR code ini.
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id', 'permission_id');
    }

    /**
     * cek apakah QR code masih aktif.
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && 
               ($this->expires_at === null || $this->expires_at > now());
    }

    /**
     * Check if QR code is expired.
     */
    public function isExpired(): bool
    {
        return $this->status === 'expired' || 
               ($this->expires_at !== null && $this->expires_at <= now());
    }

    /**
     * Tandai QR code sebagai digunakan.
     */
    public function markAsUsed(): void
    {
        $this->update(['status' => 'used']);
    }

    /**
     * Tandai QR code sebagai kadaluarsa.
     */
    public function markAsExpired(): void
    {
        $this->update(['status' => 'expired']);
    }

    /**
     * only include active QR codes.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * only include expired QR codes.
     */
    public function scopeExpired($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'expired')
              ->orWhere('expires_at', '<=', now());
        });
    }
}