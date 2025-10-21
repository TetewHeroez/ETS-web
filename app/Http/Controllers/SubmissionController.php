<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class SubmissionController extends Controller
{
    /**
     * Show the form for creating a new submission.
     */
    public function create()
    {
        $assignments = Assignment::where('is_active', true)->get();
        $user = auth()->user();
        
        return view('submissions.create', compact('assignments', 'user'));
    }

    /**
     * Store a newly created submission in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'assignment_id' => 'required|exists:assignments,id',
            'type' => 'required|in:pdf,image,link',
            'file' => 'required_if:type,pdf,image|file|max:10240', // Max 10MB
            'link' => 'required_if:type,link|url',
        ]);

        // Cek apakah user sudah submit tugas ini sebelumnya
        $existingSubmission = Submission::where('user_id', auth()->id())
            ->where('assignment_id', $validated['assignment_id'])
            ->first();

        if ($existingSubmission) {
            return back()->with('error', 'Anda sudah mengumpulkan tugas ini sebelumnya!');
        }

        $content = null;

        if ($validated['type'] === 'link') {
            $content = $validated['link'];
        } else {
            // Upload file ke Cloudinary
            $file = $request->file('file');
            
            // Upload dengan folder dan public_id custom
            $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                'folder' => 'ets-submissions',
                'public_id' => 'submission_' . auth()->id() . '_' . time(),
                'resource_type' => 'auto' // auto detect: image/pdf/raw
            ]);
            
            // Simpan secure URL dari Cloudinary
            $content = $uploadedFile->getSecurePath();
        }

        Submission::create([
            'user_id' => auth()->id(),
            'assignment_id' => $validated['assignment_id'],
            'type' => $validated['type'],
            'content' => $content,
        ]);

        return redirect()->route('submissions.create')->with('success', 'Tugas berhasil dikumpulkan!');
    }

    /**
     * Display the submission progress table.
     */
    public function table()
    {
        $assignments = Assignment::where('is_active', true)->get();
        $members = User::where('role', 'member')->orderBy('name')->get();
        
        return view('submissions.table', compact('assignments', 'members'));
    }
}
