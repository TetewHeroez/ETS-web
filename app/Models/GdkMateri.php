<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GdkMateri extends Model
{
    protected $table = 'gdk_materi';

    protected $fillable = [
        'gdk_nilai_id',
        'nama_materi',
        'deskripsi',
        'multiplier',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'multiplier' => 'float',
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'gdk_nilai_id' => 'integer',
    ];

    /**
     * Relationship: Materi belongs to Nilai
     */
    public function nilai()
    {
        return $this->belongsTo(GdkNilai::class, 'gdk_nilai_id');
    }

    /**
     * Relationship: Materi has many Metode
     */
    public function metodes()
    {
        return $this->hasMany(GdkMetode::class, 'gdk_materi_id')->orderBy('urutan');
    }

    /**
     * Scope: Only active records
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Calculate total multiplier (nilai x materi)
     */
    public function getTotalMultiplierAttribute()
    {
        return $this->nilai->multiplier * $this->multiplier;
    }
}
