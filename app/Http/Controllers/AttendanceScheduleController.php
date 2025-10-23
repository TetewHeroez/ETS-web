<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSchedule;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin() && !Auth::user()->isSuperAdmin()) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of schedules
     */
    public function index()
    {
        $schedules = AttendanceSchedule::with('attendances')
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();
        
        return view('attendance-schedules.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule
     */
    public function create()
    {
        return view('attendance-schedules.create');
    }

    /**
     * Store a newly created schedule
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'is_open' => 'boolean'
        ]);

        AttendanceSchedule::create($validated);

        return redirect()->route('attendance-schedules.index')
            ->with('success', 'Jadwal kehadiran berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified schedule
     */
    public function edit(AttendanceSchedule $attendanceSchedule)
    {
        return view('attendance-schedules.edit', compact('attendanceSchedule'));
    }

    /**
     * Update the specified schedule
     */
    public function update(Request $request, AttendanceSchedule $attendanceSchedule)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'is_active' => 'boolean',
            'is_open' => 'boolean'
        ]);

        $attendanceSchedule->update($validated);

        return redirect()->route('attendance-schedules.index')
            ->with('success', 'Jadwal kehadiran berhasil diupdate!');
    }

    /**
     * Remove the specified schedule
     */
    public function destroy(AttendanceSchedule $attendanceSchedule)
    {
        $attendanceSchedule->delete();

        return redirect()->route('attendance-schedules.index')
            ->with('success', 'Jadwal kehadiran berhasil dihapus!');
    }

    /**
     * Toggle schedule open status
     */
    public function toggleOpen(AttendanceSchedule $attendanceSchedule)
    {
        $attendanceSchedule->update([
            'is_open' => !$attendanceSchedule->is_open
        ]);

        $status = $attendanceSchedule->is_open ? 'dibuka' : 'ditutup';
        
        return redirect()->route('attendance-schedules.index')
            ->with('success', "Absensi berhasil {$status}!");
    }

    /**
     * Show attendance detail for a schedule
     */
    public function show(AttendanceSchedule $attendanceSchedule)
    {
        $attendanceSchedule->load(['attendances.user']);
        
        $members = User::where('role', 'member')->get();
        $attendedUserIds = $attendanceSchedule->attendances->pluck('user_id')->toArray();
        
        return view('attendance-schedules.show', compact('attendanceSchedule', 'members', 'attendedUserIds'));
    }

    /**
     * Mark attendance for users (admin can mark for all users)
     */
    public function markAttendance(Request $request, AttendanceSchedule $attendanceSchedule)
    {
        $validated = $request->validate([
            'attendances' => 'required|array',
            'attendances.*.user_id' => 'required|exists:users,id',
            'attendances.*.status' => 'required|in:hadir,izin,alpa',
            'attendances.*.keterangan' => 'nullable|string'
        ]);

        foreach ($validated['attendances'] as $attendanceData) {
            Attendance::updateOrCreate(
                [
                    'user_id' => $attendanceData['user_id'],
                    'attendance_schedule_id' => $attendanceSchedule->id
                ],
                [
                    'date' => $attendanceSchedule->date,
                    'status' => $attendanceData['status'],
                    'keterangan' => $attendanceData['keterangan'] ?? null
                ]
            );
        }

        return redirect()->route('attendance-schedules.show', $attendanceSchedule)
            ->with('success', 'Kehadiran berhasil disimpan!');
    }
}
