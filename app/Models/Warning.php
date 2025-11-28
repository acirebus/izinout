<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warning extends Model
{
    protected $table = 'warnings';
    protected $primaryKey = 'warning_id';
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'permission_id',
        'reason',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * mendapatkan siswa pemilik peringatan ini
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    /**
     * mendapatkan data izin terkait peringatan ini
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'permission_id', 'permission_id');
    }

    /**
     * membuat peringatan baru dan cek auto-ban
     */
    public static function createWarning(int $studentId, ?int $permissionId = null, ?string $reason = null): self
    {
        $warning = self::create([
            'student_id' => $studentId,
            'permission_id' => $permissionId,
            'reason' => $reason,
        ]);

    // cek apakah siswa harus auto-banned
        $warningCount = self::where('student_id', $studentId)->count();
    $threshold = config('app.auto_ban_threshold', 3); // default 3 peringatan

        if ($warningCount >= $threshold) {
            $student = Student::find($studentId);
            if ($student && $student->user) {
                $student->user->update(['status' => 'banned']);
                
                // membuat notifikasi auto-ban
                Notification::create([
                    'user_id' => $student->user_id,
                    'title' => 'Akun Diblokir',
                    'message' => "Akun Anda telah diblokir karena terlalu banyak pelanggaran ({$warningCount} peringatan). Silakan hubungi admin untuk mengaktifkan kembali akun Anda.",
                    'channel' => 'in_app',
                ]);
            }
        }

        return $warning;
    }

    /**
     * mendapatkan tanggal dibuat yang sudah diformat
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('d/m/Y H:i');
    }
}