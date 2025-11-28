<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    public function isGuru()
    {
        return $this->role === 'guru';
    }
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';

    /**
     * atribut yang bisa diisi massal
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password_hash',
        'name',
        'phone',
        'role',
        'school_id',
        'status',
    ];

    /**
     * atribut yang disembunyikan saat serialisasi
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password_hash',
    ];

    /**
     * mendapatkan atribut yang perlu di-cast
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'role' => 'string',
            'status' => 'string',
        ];
    }

    /**
     * mendapatkan nama field password
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    /**
     * mendapatkan sekolah pemilik user
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    /**
     * mendapatkan data siswa yang terkait dengan user
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'user_id', 'user_id');
    }

    /**
     * mendapatkan data izin yang disetujui user ini (admin)
     */
    public function approvedPermissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'admin_id', 'user_id');
    }

    /**
     * mendapatkan log aktivitas oleh user ini
     */
    public function permissionLogs(): HasMany
    {
        return $this->hasMany(PermissionLog::class, 'actor_id', 'user_id');
    }

    /**
     * mendapatkan notifikasi untuk user ini
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id', 'user_id');
    }

    /**
     * cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin_bk';
    }

    /**
     * cek apakah user adalah siswa
     */
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }

    /**
     * scope query untuk user aktif saja
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * scope query untuk user admin saja
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin_bk');
    }

    /**
     * scope query untuk user siswa saja
     */
    public function scopeStudents($query)
    {
        return $query->where('role', 'student');
    }
}