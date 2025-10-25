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
    ];

    protected $casts = [
        'multiplier' => 'float',
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
        return $this->hasMany(GdkMetode::class, 'gdk_materi_id');
    }

    /**
     * Calculate total multiplier (nilai x materi)
     */
    public function getTotalMultiplierAttribute()
    {
        return $this->nilai->multiplier * $this->multiplier;
    }
}
