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
            
            try {
                // Upload dengan folder dan public_id custom
                $uploadedFile = Cloudinary::uploadApi()->upload($file->getRealPath(), [
                    'folder' => 'myhimatika/submissions',
                    'public_id' => 'submission_' . auth()->id() . '_' . time(),
                    'resource_type' => 'auto' // auto detect: image/pdf/raw
                ]);
                
                // Extract secure URL dari response
                $securePath = null;
                if (is_array($uploadedFile)) {
                    $securePath = $uploadedFile['secure_url'] ?? $uploadedFile['url'] ?? null;
                } elseif (is_object($uploadedFile)) {
                    $securePath = $uploadedFile->secure_url ?? $uploadedFile->url ?? null;
                }

                if (!$securePath) {
                    throw new \Exception('Failed to get file URL from Cloudinary');
                }

                $content = $securePath;
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal upload file ke Cloudinary: ' . $e->getMessage());
            }
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
    public function table(Request $request)
    {
        $assignments = Assignment::where('is_active', true)->get();

        // Support search by name or nrp via query param 'search'
        $search = $request->input('search');

        // Get sorting parameters
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        
        // Validate sort column to prevent SQL injection
        $allowedSorts = ['name', 'nrp', 'kelompok'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'name';
        }

        $membersQuery = User::where('role', 'member');
        if ($search) {
            $membersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nrp', 'like', "%{$search}%");
            });
        }

        $members = $membersQuery->orderBy($sortBy, $sortOrder)->get();
        
        return view('submissions.table', compact('assignments', 'members'));
    }
}
