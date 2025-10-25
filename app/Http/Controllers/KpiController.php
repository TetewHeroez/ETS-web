<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\Submission;

class KpiController extends Controller
{
    /**
     * Tampilkan halaman KPI untuk admin dan superadmin
     * KPI = Key Performance Indicator (kumulatif semua member)
     * PI = Performance Indicator (per individu member)
     */
    public function index(Request $request)
    {
        // Get all members
        $query = User::where('role', 'member')->where('status', 'aktif');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nrp', 'like', "%{$search}%");
            });
        }

        // Kelompok filter
        if ($request->filled('kelompok')) {
            $query->where('kelompok', $request->kelompok);
        }

        // Get total attendances for calculation
        $totalAttendances = Attendance::count();
        
        // Get all assignments with GDK data
        $assignments = Assignment::with('gdkFlowchart.metode.materi.nilai')->get();
        $totalGdkWeight = $assignments->sum(function($assignment) {
            return $assignment->gdkFlowchart ? $assignment->gdkFlowchart->total_multiplier : 0;
        });

        // Calculate KPI for each member
        $members = $query->get()->map(function ($member) use ($totalAttendances, $assignments, $totalGdkWeight) {
            // Calculate attendance score
            $userAttendances = Attendance::where('user_id', $member->id)
                ->where('status', 'hadir')
                ->count();
            $attendanceScore = $totalAttendances > 0 ? ($userAttendances / $totalAttendances) * 100 : 0;

            // Calculate submission score based on GDK multipliers
            $userGdkScore = 0;
            foreach ($assignments as $assignment) {
                $hasSubmission = $member->submissions()->where('assignment_id', $assignment->id)->exists();
                $gdkMultiplier = $assignment->gdkFlowchart ? $assignment->gdkFlowchart->total_multiplier : 0;
                $userGdkScore += ($hasSubmission ? 1 : 0) * $gdkMultiplier;
            }
            
            $submissionScore = $totalGdkWeight > 0 ? ($userGdkScore / $totalGdkWeight) * 100 : 0;

            // Use KPI attribute from User model (which uses GDK multipliers)
            $totalPI = round($member->kpi, 2);

            // Add calculated fields to member object
            $member->attendance_score = round($attendanceScore, 2);
            $member->submission_score = round($submissionScore, 2);
            $member->gdk_score = round($userGdkScore, 2);
            $member->total_pi = $totalPI;

            return $member;
        });

        // Sorting
        $sortField = $request->get('sort', 'total_pi');
        $sortDirection = $request->get('direction', 'desc');

        $allowedSorts = ['name', 'nrp', 'kelompok', 'total_pi'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'total_pi';
        }

        if ($sortDirection === 'asc') {
            $members = $members->sortBy($sortField);
        } else {
            $members = $members->sortByDesc($sortField);
        }

        // Calculate statistics
        $totalMembers = $members->count();
        $averagePI = $members->avg('total_pi') ?? 0;
        $highestPI = $members->max('total_pi') ?? 0;
        $lowestPI = $members->min('total_pi') ?? 0;

        // Calculate KPI (Key Performance Indicator - Kumulatif SEMUA member)
        // KPI Kehadiran: Total kehadiran seluruh member
        $totalPossibleAttendances = $totalMembers * $totalAttendances;
        $totalActualAttendances = Attendance::where('status', 'hadir')->count();
        $kpiAttendance = $totalPossibleAttendances > 0 ? ($totalActualAttendances / $totalPossibleAttendances) * 100 : 0;

        // KPI Tugas: Total pengumpulan tugas berdasarkan GDK multiplier
        $totalPossibleGdkScore = $totalMembers * $totalGdkWeight;
        $totalActualGdkScore = $members->sum('gdk_score');
        $kpiSubmission = $totalPossibleGdkScore > 0 ? ($totalActualGdkScore / $totalPossibleGdkScore) * 100 : 0;

        // KPI Score: Total KPI dari semua member
        $kpiScore = $members->sum('total_pi');

        // Total KPI Organisasi (rata-rata PI semua member)
        $totalKPI = round($averagePI, 2);

        // Get unique kelompoks for filter
        $kelompoks = User::where('role', 'member')
            ->whereNotNull('kelompok')
            ->distinct()
            ->pluck('kelompok')
            ->sort();

        // Paginate manually
        $perPage = 15;
        $currentPage = $request->get('page', 1);
        $items = $members->slice(($currentPage - 1) * $perPage, $perPage)->values();
        
        $members = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $members->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('kpi.index', compact(
            'members',
            'totalMembers',
            'averagePI',
            'highestPI',
            'lowestPI',
            'totalKPI',
            'kpiAttendance',
            'kpiSubmission',
            'kpiScore',
            'kelompoks'
        ));
    }
}
