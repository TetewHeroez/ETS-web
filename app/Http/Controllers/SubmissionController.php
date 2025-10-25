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
     * Show all submissions available for current member to upload
     */
    public function index()
    {
        // Only members can access
        if (auth()->user()->role !== 'member') {
            abort(403, 'Unauthorized - Hanya member yang dapat melihat tugas.');
        }

        $assignments = Assignment::orderBy('created_at', 'desc')->get();

        return view('assignments.my-submissions', compact('assignments'));
    }

    /**
     * Show the form for uploading a new submission.
     */
    public function upload(Assignment $assignment)
    {
        // Only members can access
        if (auth()->user()->role !== 'member') {
            abort(403, 'Unauthorized - Hanya member yang dapat mengumpulkan tugas.');
        }

        $previousSubmission = auth()->user()->submissions()
            ->where('assignment_id', $assignment->id)
            ->first();

        return view('assignments.upload', compact('assignment', 'previousSubmission'));
    }

    /**
     * Store a newly created submission in storage.
     */
    public function store(Request $request)
    {
        $assignment = Assignment::findOrFail($request->input('assignment_id'));

        // Validate based on submission_type from assignment
        if ($assignment->submission_type === 'link') {
            $validated = $request->validate([
                'assignment_id' => 'required|exists:assignments,id',
                'link' => 'required|url',
            ]);
        } else {
            $validated = $request->validate([
                'assignment_id' => 'required|exists:assignments,id',
                'file' => 'required|file|max:5120|mimes:' . ($assignment->submission_type === 'pdf' ? 'pdf' : 'jpeg,jpg,png,gif,svg'),
            ]);
        }

        // Cek apakah user sudah submit tugas ini sebelumnya
        $existingSubmission = Submission::where('user_id', auth()->id())
            ->where('assignment_id', $assignment->id)
            ->first();

        if ($existingSubmission) {
            if (request()->wantsJson()) {
                return response()->json(['message' => 'Anda sudah mengumpulkan tugas ini sebelumnya!'], 422);
            }
            return back()->with('error', 'Anda sudah mengumpulkan tugas ini sebelumnya!');
        }

        $content = null;

        if ($assignment->submission_type === 'link') {
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
                \Log::info('Submission uploaded to Cloudinary', ['url' => $content]);
            } catch (\Exception $e) {
                \Log::error('Cloudinary upload error', ['error' => $e->getMessage()]);
                if (request()->wantsJson()) {
                    return response()->json(['message' => 'Gagal upload file: ' . $e->getMessage()], 500);
                }
                return back()->with('error', 'Gagal upload file: ' . $e->getMessage());
            }
        }

        Submission::create([
            'user_id' => auth()->id(),
            'assignment_id' => $assignment->id,
            'type' => $assignment->submission_type,
            'content' => $content,
        ]);

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Tugas berhasil dikumpulkan!'], 200);
        }

        return redirect()->route('assignments.upload', $assignment)
            ->with('success', 'Tugas berhasil dikumpulkan!');
    }

    /**
     * Display the submission progress table.
     */
    public function table(Request $request)
    {
        $assignments = Assignment::all();

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
        
        return view('assignments.submissions-progress', compact('assignments', 'members'));
    }
}
