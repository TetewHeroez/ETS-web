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
    ];

    protected $casts = [
        'multiplier' => 'float',
    ];

    /**
     * Relationship: Nilai has many Materi
     */
    public function materis()
    {
        return $this->hasMany(GdkMateri::class, 'gdk_nilai_id');
    }

}
