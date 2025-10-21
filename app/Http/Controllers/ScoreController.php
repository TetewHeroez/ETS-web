<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\Assignment;
use App\Models\User;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Display scoring page for specific assignment
     */
    public function index(Assignment $assignment)
    {
        $members = User::where('role', 'member')->get();
        $scores = Score::where('assignment_id', $assignment->id)
            ->pluck('score', 'user_id');
        
        return view('scores.index', compact('assignment', 'members', 'scores'));
    }

    /**
     * Store or update scores for assignment
     */
    public function store(Request $request, Assignment $assignment)
    {
        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string',
        ]);

        foreach ($request->scores as $userId => $scoreValue) {
            if ($scoreValue !== null) {
                Score::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'assignment_id' => $assignment->id,
                    ],
                    [
                        'score' => $scoreValue,
                        'notes' => $request->notes[$userId] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('scores.index', $assignment)
            ->with('success', 'Nilai berhasil disimpan!');
    }

    /**
     * Display leaderboard (ranking KPI)
     */
    public function leaderboard()
    {
        $members = User::where('role', 'member')
            ->with(['scores.assignment'])
            ->get()
            ->map(function($user) {
                $user->total_kpi = $user->kpi;
                return $user;
            })
            ->sortByDesc('total_kpi');
        
        $assignments = Assignment::orderBy('created_at', 'desc')->get();

        return view('scores.leaderboard', compact('members', 'assignments'));
    }
}
