<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GdkMetode extends Model
{
    protected $table = 'gdk_metode';

    protected $fillable = [
        'gdk_materi_id',
        'nama_metode',
        'deskripsi',
        'multiplier',
        'pa',
        'pi',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'multiplier' => 'float',
        'is_active' => 'boolean',
        'urutan' => 'integer',
        'gdk_materi_id' => 'integer',
    ];

    /**
     * Relationship: Metode belongs to Materi
     */
    public function materi()
    {
        return $this->belongsTo(GdkMateri::class, 'gdk_materi_id');
    }

    /**
     * Scope: Only active records
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Calculate total multiplier (nilai x materi x metode)
     */
    public function getTotalMultiplierAttribute()
    {
        return $this->materi->nilai->multiplier * $this->materi->multiplier * $this->multiplier;
    }
}
