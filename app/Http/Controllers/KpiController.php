<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\Score;

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
        $totalAssignments = Assignment::where('is_active', true)->sum('weight');

        // Calculate KPI for each member
        $members = $query->get()->map(function ($member) use ($totalAttendances, $totalAssignments) {
            // Calculate attendance score
            $userAttendances = Attendance::where('user_id', $member->id)
                ->where('status', 'hadir')
                ->count();
            $attendanceScore = $totalAttendances > 0 ? ($userAttendances / $totalAttendances) * 100 : 0;

            // Calculate submission score
            $userSubmissions = Submission::where('user_id', $member->id)
                ->whereHas('assignment', function ($q) {
                    $q->where('is_active', true);
                })
                ->with('assignment')
                ->get();

            $submissionScore = 0;
            if ($totalAssignments > 0) {
                $userTotalWeight = $userSubmissions->sum(function ($submission) {
                    return $submission->assignment->weight ?? 0;
                });
                $submissionScore = ($userTotalWeight / $totalAssignments) * 100;
            }

            // Calculate average score from all graded assignments
            $averageScore = Score::where('user_id', $member->id)->avg('score') ?? 0;

            // Calculate total PI (Performance Indicator) - rata-rata dari attendance + submission + average score
            $totalPI = round(($attendanceScore + $submissionScore + $averageScore) / 3, 2);

            // Add calculated fields to member object
            $member->attendance_score = round($attendanceScore, 2);
            $member->submission_score = round($submissionScore, 2);
            $member->average_score = round($averageScore, 2);
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

        // KPI Tugas: Total pengumpulan tugas seluruh member
        $totalPossibleSubmissions = $totalMembers * Assignment::where('is_active', true)->count();
        $totalActualSubmissions = Submission::whereHas('assignment', function($q) {
            $q->where('is_active', true);
        })->count();
        $kpiSubmission = $totalPossibleSubmissions > 0 ? ($totalActualSubmissions / $totalPossibleSubmissions) * 100 : 0;

        // KPI Nilai: Rata-rata nilai seluruh member
        $kpiScore = Score::avg('score') ?? 0;

        // Total KPI Organisasi
        $totalKPI = round(($kpiAttendance + $kpiSubmission + $kpiScore) / 3, 2);

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
