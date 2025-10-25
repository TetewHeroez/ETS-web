<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GdkFlowchart extends Model
{
    protected $table = 'gdk_flowchart';

    protected $fillable = [
        'gdk_metode_id',
        'judul',
        'deskripsi',
        'image_path',
    ];

    protected $casts = [
        'gdk_metode_id' => 'integer',
    ];

    /**
     * Relationship: Flowchart belongs to Metode
     */
    public function metode()
    {
        return $this->belongsTo(GdkMetode::class, 'gdk_metode_id');
    }

    /**
     * Get total multiplier (nilai × materi × metode)
     */
    public function getTotalMultiplierAttribute()
    {
        if (!$this->metode) {
            return 0;
        }
        return $this->metode->total_multiplier;
    }

    /**
     * Relationship: Flowchart has many Assignments
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'gdk_flowchart_id');
    }
}
