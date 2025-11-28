<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'class_name',
        'student_number',
    ];

    /**
     * mendapatkan user pemilik data siswa
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * mendapatkan daftar izin milik siswa
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'student_id', 'student_id');
    }

    /**
     * mendapatkan daftar peringatan untuk siswa
     */
    public function warnings(): HasMany
    {
        return $this->hasMany(Warning::class, 'student_id', 'student_id');
    }

    /**
     * mendapatkan sekolah melalui relasi user
     */
    public function school(): BelongsTo
    {
        return $this->user->school();
    }

    /**
     * mendapatkan izin aktif
     */
    public function activePermissions()
    {
        return $this->permissions()
            ->where('status', 'approved')
            ->where(function ($query) {
                $query->whereNull('time_end')
                    ->orWhere('time_end', '>', now());
            });
    }

    /**
     * mendapatkan izin yang masih pending
     */
    public function pendingPermissions()
    {
        return $this->permissions()->where('status', 'submitted');
    }

    /**
     * mendapatkan izin yang sudah disetujui
     */
    public function approvedPermissions()
    {
        return $this->permissions()->where('status', 'approved');
    }

    /**
     * mendapatkan izin yang ditolak
     */
    public function rejectedPermissions()
    {
        return $this->permissions()->where('status', 'rejected');
    }

    /**
     * menghitung total peringatan untuk auto-ban
     */
    public function countWarnings()
    {
        return $this->warnings()->count();
    }
}