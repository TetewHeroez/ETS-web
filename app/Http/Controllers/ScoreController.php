<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display scoring page for specific assignment (READ-ONLY)
     * Scores are calculated automatically from submissions
     */
    public function index(Assignment $assignment, Request $request)
    {
        // Get sorting parameters
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        
        // Validate sort column to prevent SQL injection
        $allowedSorts = ['name', 'nrp', 'kelompok'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'name';
        }
        
        // Load assignment with GDK data
        $assignment->load('gdkFlowchart.metode.materi.nilai');
        
        $members = User::where('role', 'member')
            ->with(['submissions' => function($query) use ($assignment) {
                $query->where('assignment_id', $assignment->id);
            }])
            ->orderBy($sortBy, $sortOrder)
            ->get();
        
        // Calculate scores for each member
        $scores = $members->map(function($member) use ($assignment) {
            $hasSubmission = $member->submissions->isNotEmpty();
            $gdkMultiplier = $assignment->gdkFlowchart ? $assignment->gdkFlowchart->total_multiplier : 0;
            $pi = ($hasSubmission ? 1 : 0) * $gdkMultiplier;
            
            return [
                'user_id' => $member->id,
                'has_submission' => $hasSubmission,
                'gdk_multiplier' => $gdkMultiplier,
                'pi' => $pi,
            ];
        })->keyBy('user_id');
        
        return view('scores.index', compact('assignment', 'members', 'scores'));
    }

    /**
     * Display leaderboard (ranking KPI)
     */
    public function leaderboard(Request $request)
    {
        // Get sorting parameters
        $sortBy = $request->input('sort_by', 'total_kpi');
        $sortOrder = $request->input('sort_order', 'desc');
        
        $members = User::where('role', 'member')
            ->with(['submissions.assignment.gdkFlowchart.metode.materi.nilai'])
            ->get()
            ->map(function($user) {
                $user->total_kpi = $user->kpi;
                return $user;
            });
        
        // Sort members based on parameters
        if ($sortBy === 'total_kpi') {
            $members = $sortOrder === 'asc' ? $members->sortBy('total_kpi') : $members->sortByDesc('total_kpi');
        } elseif ($sortBy === 'name') {
            $members = $sortOrder === 'asc' ? $members->sortBy('name') : $members->sortByDesc('name');
        } elseif ($sortBy === 'nrp') {
            $members = $sortOrder === 'asc' ? $members->sortBy('nrp') : $members->sortByDesc('nrp');
        } elseif ($sortBy === 'kelompok') {
            $members = $sortOrder === 'asc' ? $members->sortBy('kelompok') : $members->sortByDesc('kelompok');
        }
        
        $assignments = Assignment::with('gdkFlowchart.metode.materi.nilai')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kpi.index', compact('members', 'assignments'));
    }
}
