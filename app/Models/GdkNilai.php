<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GdkNilai extends Model
{
    protected $table = 'gdk_nilai';

    protected $fillable = [
        'nama_nilai',
        'deskripsi',
        'multiplier',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'multiplier' => 'float',
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Relationship: Nilai has many Materi
     */
    public function materis()
    {
        return $this->hasMany(GdkMateri::class, 'gdk_nilai_id')->orderBy('urutan');
    }

    /**
     * Scope: Only active records
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
