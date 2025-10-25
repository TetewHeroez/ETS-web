<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GdkFlowchart extends Model
{
    protected $table = 'gdk_flowchart';

    protected $fillable = [
        'judul',
        'deskripsi',
        'image_path',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Scope: Only active records
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
