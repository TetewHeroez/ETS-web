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
    ];

    protected $casts = [
        'multiplier' => 'float',
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
     * Calculate total multiplier (nilai x materi x metode)
     */
    public function getTotalMultiplierAttribute()
    {
        return $this->materi->nilai->multiplier * $this->materi->multiplier * $this->multiplier;
    }
}
