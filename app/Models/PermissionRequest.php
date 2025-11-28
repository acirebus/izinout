<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class PermissionRequest extends Model
{
    protected $fillable = [
        'student_id',
        'reason',
        'time_start',
        'time_end',
        'status',
        'evidence_url',
        'admin_notes',
        'approved_by',
        'approved_at',
        'qr_code',
    ];

    protected $casts = [
        'time_start' => 'datetime',
        'time_end' => 'datetime',
        'approved_at' => 'datetime',
        'status' => 'string',
    ];

    /**
     * mendapatkan siswa pemilik permintaan izin
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * mendapatkan admin yang menyetujui permintaan
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * cek apakah izin masih aktif
     */
    public function isActive(): bool
    {
        if ($this->status !== 'approved') {
            return false;
        }

        $now = Carbon::now();
        
    // jika tidak ada waktu selesai, dianggap aktif (izin permanen)
        if (!$this->time_end) {
            return $now >= $this->time_start;
        }
        
        return $now >= $this->time_start && $now <= $this->time_end;
    }

    /**
     * cek apakah izin sudah kadaluarsa
     */
    public function isExpired(): bool
    {
        if ($this->status !== 'approved' || !$this->time_end) {
            return false;
        }
        
        return Carbon::now() > $this->time_end;
    }

    /**
     * mendapatkan status aktif izin
     */
    public function getActiveStatus(): ?string
    {
        if ($this->status !== 'approved') {
            return null;
        }

        if ($this->isActive()) {
            return 'active';
        } elseif ($this->isExpired()) {
            return 'expired';
        }
        
        return null;
    }

    /**
     * waktu mulai
     */
    public function getFormattedTimeStartAttribute(): string
    {
        return $this->time_start->format('d/m/Y H:i');
    }

    /**
     * waktu selesai
     */
    public function getFormattedTimeEndAttribute(): ?string
    {
        return $this->time_end ? $this->time_end->format('d/m/Y H:i') : null;
    }

    /**
     * waktu dibuat
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * pending requests
     */
    public function scopePending($query)
    {
    return $query->where('status', 'submitted');
    }

    /**
     * approved requests.
     */
    public function scopeApproved($query)
    {
    return $query->where('status', 'approved');
    }

    /**
     * rejected requests.
     */
    public function scopeRejected($query)
    {
    return $query->where('status', 'rejected');
    }

    /**
     * active permissions.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'disetujui')
            ->where(function ($q) {
                $q->whereNull('time_end')
                  ->orWhere('time_end', '>', now());
            })
            ->where('time_start', '<=', now());
    }
}