<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Check if user has access (Koor IC, Koor SC, SC only)
     */
    private function checkAccess()
    {
        $user = auth()->user();
        $allowedJabatan = ['Koor IC', 'Koor SC', 'SC'];
        
        if (!in_array($user->jabatan, $allowedJabatan)) {
            abort(403, 'Unauthorized - Hanya Koor IC, Koor SC, dan SC yang dapat membuat/edit tugas.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get sorting parameters
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        
        // Validate sort column to prevent SQL injection
        $allowedSorts = ['title', 'deadline', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'created_at';
        }
        
        $assignments = Assignment::orderBy($sortBy, $sortOrder)->get();
        return view('assignments.index', compact('assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkAccess();
        // Get all GDK Flowcharts with full relationship chain
        $flowcharts = \App\Models\GdkFlowchart::with('metode.materi.nilai')->get();
        return view('assignments.create', compact('flowcharts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkAccess();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'submission_type' => 'required|in:pdf,image,link',
            'gdk_flowchart_id' => 'required|exists:gdk_flowchart,id', // Now required!
        ]);

        Assignment::create($validated);

        return redirect()->route('assignments.index')->with('success', 'Tugas berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assignment $assignment)
    {
        $this->checkAccess();
        // Get all GDK Flowcharts with full relationship chain
        $flowcharts = \App\Models\GdkFlowchart::with('metode.materi.nilai')->get();
        return view('assignments.edit', compact('assignment', 'flowcharts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assignment $assignment)
    {
        $this->checkAccess();
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'submission_type' => 'required|in:pdf,image,link',
            'gdk_flowchart_id' => 'required|exists:gdk_flowchart,id', // Now required!
        ]);

        $assignment->update($validated);

        return redirect()->route('assignments.index')->with('success', 'Tugas berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assignment $assignment)
    {
        $assignment->delete();

        return redirect()->route('assignments.index')->with('success', 'Tugas berhasil dihapus!');
    }
}
