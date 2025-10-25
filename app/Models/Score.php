<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'user_id',
        'assignment_id',
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

    /**
     * Check if user has submitted this assignment
     */
    public function getHasSubmissionAttribute()
    {
        return $this->assignment->hasSubmissionFrom($this->user_id);
    }

    /**
     * Get submission status (1 if submitted, 0 if not)
     */
    public function getSubmissionStatusAttribute()
    {
        return $this->has_submission ? 1 : 0;
    }

    /**
     * Get GDK total multiplier from assignment
     */
    public function getGdkMultiplierAttribute()
    {
        if (!$this->assignment->gdkFlowchart) {
            return 0;
        }
        return $this->assignment->gdkFlowchart->total_multiplier;
    }

    /**
     * Calculate PI (Performance Indicator) automatically
     * PI = submission_status (0 or 1) × GDK total multiplier
     */
    public function getPointAttribute()
    {
        return $this->submission_status * $this->gdk_multiplier;
    }
}
