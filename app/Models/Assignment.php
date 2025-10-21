<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'is_active',
        'weight', // Bobot tugas untuk perhitungan PI
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Submissions relationship
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
    
    /**
     * Scores relationship
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
    
    /**
     * Check if assignment has submission from user
     */
    public function hasSubmissionFrom($userId)
    {
        return $this->submissions()->where('user_id', $userId)->exists();
    }
    
    /**
     * Get score for specific user
     */
    public function getScoreForUser($userId)
    {
        return $this->scores()->where('user_id', $userId)->first();
    }
}