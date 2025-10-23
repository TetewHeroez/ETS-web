<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Tampilkan tabel absensi (Admin only)
     */
    public function index(Request $request)
    {
        // Hanya admin yang bisa akses
        if (!Auth::user()->isAdmin() && !Auth::user()->isSuperadmin()) {
            abort(403, 'Unauthorized');
        }

        $date = $request->input('date', now()->format('Y-m-d'));
        
        // Get sorting parameters
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        
        // Ambil semua member dengan sorting
        $users = User::where('role', 'member')
            ->orderBy($sortBy, $sortOrder)
            ->get();
        
        // Ambil absensi untuk tanggal tertentu
        $attendances = Attendance::where('date', $date)
            ->get()
            ->keyBy('user_id');

        return view('attendances.index', compact('users', 'attendances', 'date', 'sortBy', 'sortOrder'));
    }

    /**
     * Update atau create absensi
     */
    public function updateOrCreate(Request $request)
    {
        // Hanya admin yang bisa akses
        if (!Auth::user()->isAdmin() && !Auth::user()->isSuperadmin()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:hadir,izin,alpa',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Attendance::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'date' => $request->date,
            ],
            [
                'status' => $request->status,
                'keterangan' => $request->keterangan,
            ]
        );

        return redirect()->back()->with('success', 'Absensi berhasil disimpan');
    }

    /**
     * Tampilkan detail kehadiran member (Member only)
     */
    public function myAttendance()
    {
        // Hanya member yang bisa akses halaman ini
        if (!Auth::user()->isMember()) {
            abort(403, 'Unauthorized');
        }

        $userId = Auth::id();
        
        // Ambil semua absensi user
        $attendances = Attendance::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->paginate(15);

        // Hitung statistik
        $stats = [
            'hadir' => Attendance::where('user_id', $userId)->where('status', 'hadir')->count(),
            'izin' => Attendance::where('user_id', $userId)->where('status', 'izin')->count(),
            'alpa' => Attendance::where('user_id', $userId)->where('status', 'alpa')->count(),
        ];

        return view('attendances.my-attendance', compact('attendances', 'stats'));
    }
}
