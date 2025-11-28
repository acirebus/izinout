<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    protected $table = 'schools';
    protected $primaryKey = 'school_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'unique_code',
        'address',
    ];

    /**
     * mendapatkan user untuk sekolah ini
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'school_id', 'school_id');
    }

    /**
     * mendapatkan data izin untuk sekolah ini
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'school_id', 'school_id');
    }
}