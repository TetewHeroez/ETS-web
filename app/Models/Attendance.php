<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'attendance_schedule_id',
        'date',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke AttendanceSchedule
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(AttendanceSchedule::class, 'attendance_schedule_id');
    }
}
