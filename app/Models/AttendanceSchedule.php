<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AttendanceSchedule extends Model
{
    protected $fillable = [
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'is_active',
        'is_open'
    ];

    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean',
        'is_open' => 'boolean'
    ];

    /**
     * Get attendances for this schedule
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get active schedules
     */
    public static function getActiveSchedules()
    {
        return self::where('is_active', true)
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();
    }

    /**
     * Get open schedules (available for attendance)
     */
    public static function getOpenSchedules()
    {
        return self::where('is_active', true)
            ->where('is_open', true)
            ->orderBy('date', 'desc')
            ->get();
    }

    /**
     * Check if user has attended this schedule
     */
    public function hasUserAttended($userId)
    {
        return $this->attendances()->where('user_id', $userId)->exists();
    }

    /**
     * Get attendance count by status
     */
    public function getAttendanceCount($status)
    {
        return $this->attendances()->where('status', $status)->count();
    }

    /**
     * Get total attendance count
     */
    public function getTotalAttendance()
    {
        return $this->attendances()->count();
    }
}
