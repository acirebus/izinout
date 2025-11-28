<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Permission extends Model
{
    /**
     * mendapatkan guru yang meng-approve
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_id', 'user_id');
    }
    protected $table = 'permissions';
    protected $primaryKey = 'permission_id';
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';

    /**
     * Mendapatkan waktu selesai otomatis (20:00 di hari time_start jika time_end null)
     */
    public function getAutoTimeEndAttribute()
    {
        if ($this->time_end) {
            return $this->time_end;
        }
        if ($this->time_start) {
            // Set jam 20:00 di hari time_start
            return $this->time_start->copy()->setTime(20, 0, 0);
        }
        return null;
    }
    protected $fillable = [
        'student_id',
        'school_id',
        'reason',
        'evidence_path',
        'time_start',
        'time_end',
        'type',
        'status',
        'admin_id',
        'guru_id',
        'guru_approved_at',
    ];
    /**
     * Set type to 'leave' automatically if time_end is empty
     */
    public function setTimeEndAttribute($value)
    {
        $this->attributes['time_end'] = $value;
        if (empty($value)) {
            $this->attributes['type'] = 'leave';
        }
    }

    /**
     * Accessor for leave explanation
     */
    public function getLeaveExplanationAttribute(): ?string
    {
        if ($this->type === 'leave' && empty($this->time_end)) {
            return 'Izin berlaku tanpa batas waktu akhir (leave). Siswa dapat kembali kapan saja sesuai kebijakan sekolah.';
        }
        return null;
    }

    protected $casts = [
        'time_start' => 'datetime',
        'time_end' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'guru_approved_at' => 'datetime',
        'status' => 'string',
        'type' => 'string',
    ];
    /**
     * mendapatkan waktu approval guru yang sudah diformat
     */
    public function getFormattedGuruApprovedAtAttribute(): ?string
    {
        if ($this->guru_approved_at) {
            $dt = $this->guru_approved_at instanceof \Carbon\Carbon ? $this->guru_approved_at : \Carbon\Carbon::parse($this->guru_approved_at);
            return $dt->format('d/m/Y H:i');
        }
        return null;
    }

    /**
     * mendapatkan siswa pemilik permintaan izin
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    /**
     * mendapatkan sekolah pemilik permintaan izin
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    /**
     * mendapatkan admin yang menyetujui permintaan
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id', 'user_id');
    }

    /**
     * mendapatkan qr code untuk izin ini
     */
    public function qrPass(): HasOne
    {
        return $this->hasOne(QrPass::class, 'permission_id', 'permission_id');
    }

    /**
     * mendapatkan log untuk izin ini
     */
    public function permissionLogs(): HasMany
    {
        return $this->hasMany(PermissionLog::class, 'permission_id', 'permission_id');
    }

    /**
     * mendapatkan peringatan terkait izin ini
     */
    public function warning(): HasOne
    {
        return $this->hasOne(Warning::class, 'permission_id', 'permission_id');
    }

    /**
     * cek apakah izin aktif
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
     * mendapatkan waktu mulai yang sudah diformat
     */
    public function getFormattedTimeStartAttribute(): string
    {
        return $this->time_start->format('d/m/Y H:i');
    }

    /**
     * mendapatkan waktu selesai yang sudah diformat
     */
    public function getFormattedTimeEndAttribute(): ?string
    {
        return $this->time_end ? $this->time_end->format('d/m/Y H:i') : null;
    }

    /**
     * mendapatkan tanggal dibuat yang sudah diformat
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }

    /**
     * scope query untuk permintaan pending saja
     */
    public function scopePending($query)
    {
        return $query->where('status', 'submitted');
    }

    /**
     * scope query untuk permintaan yang sudah disetujui
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * scope query untuk permintaan yang ditolak
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * scope query untuk permintaan yang kadaluarsa
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /**
     * scope query untuk izin yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'approved')
            ->where(function ($q) {
                $q->whereNull('time_end')
                  ->orWhere('time_end', '>', now());
            })
            ->where('time_start', '<=', now());
    }
}