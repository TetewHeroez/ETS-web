<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'user_id',
        'assignment_id',
        'score',
        'notes',
    ];

    // Relationship ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship ke Assignment
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    // Hitung PI (Poin Individu) = score * weight
    public function getPointAttribute()
    {
        return $this->score * $this->assignment->weight;
    }
}
