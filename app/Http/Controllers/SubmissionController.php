<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class SubmissionController extends Controller
{
    /**
     * Show assignment selection page for members to choose which assignment to upload.
     */
    public function selectAssignment()
    {
        // Only members can access
        if (auth()->user()->role !== 'member') {
            abort(403, 'Unauthorized - Hanya member yang dapat mengumpulkan tugas.');
        }

        $assignments = Assignment::orderBy('deadline', 'asc')->get();

        return view('assignments.select', compact('assignments'));
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
        $userId = Auth::id();

        // --- 1. Validasi ---
        $rules = [
            'assignment_id' => 'required|exists:assignments,id',
            'notes' => 'nullable|string|max:1000',
        ];

        if ($assignment->submission_type === 'link') {
            $rules['link'] = 'required|url|max:2048';
        } else {
            $rules['file'] = 'required|file|max:5120|mimes:' . ($assignment->submission_type === 'pdf' ? 'pdf' : 'jpeg,jpg,png,gif,svg');
        }

        $validator = Validator::make($request->all(), $rules);

        // Handle validasi gagal untuk AJAX
        if ($validator->fails()) {
            if ($request->wantsJson()) {
                // Kirim error validasi pertama sebagai JSON
                return response()->json(['message' => $validator->errors()->first()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        $content = null;

        try {
            if ($assignment->submission_type === 'link') {
                $content = $validated['link'];
            } else {
                // --- 2. Logika Upload (Cara Bersih) ---
                $file = $request->file('file');

                // Buat Public ID KONSISTEN (TANPA time())
                // Ini adalah "nama file" unik di Cloudinary untuk user ini & tugas ini.
                $publicId = 'myhimatika/submissions/user_' . $userId . '_assignment_' . $assignment->id;

                // Upload menggunakan 'Cloudinary::upload' (lebih sederhana)
                $uploadedFile = Cloudinary::uploadApi()->upload($file->getRealPath(), [
                    'public_id' => $publicId,
                    'overwrite' => true,      // SURUH CLOUDINARY TIMPA FILE LAMA
                    'resource_type' => 'auto'
                ])->getArrayCopy();

                $securePath = $uploadedFile['secure_url'] ?? $uploadedFile['url'] ?? null;

            if (!$securePath) {

                throw new \Exception('Failed to get file URL from Cloudinary');

            }



            $content = $securePath;

            \Log::info('Submission uploaded to Cloudinary', ['url' => $content]);
            }

            // --- 3. Simpan ke DB (Cara Bersih) ---
            // 'updateOrCreate' menggantikan blok if/else Anda di akhir.
            Submission::updateOrCreate(
                [
                    'user_id' => $userId,               // Kunci pencarian
                    'assignment_id' => $assignment->id, // Kunci pencarian
                ],
                [
                    'type' => $assignment->submission_type, // Data untuk di-update/create
                    'content' => $content,
                    'notes' => $request->input('notes'), // Tambahkan notes
                ]
            );

            $message = 'Tugas berhasil dikumpulkan/diperbarui!';

            // === 4. INI PERBAIKAN ERROR ANDA ===
            // Kembalikan JSON jika diminta oleh 'fetch'
            if ($request->wantsJson()) {
                return response()->json(['message' => $message], 200);
            }

            // Jika tidak, baru redirect (untuk form submit biasa)
            return redirect()->route('assignments.upload', $assignment)
                ->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Cloudinary upload error', ['error' => $e->getMessage()]);
            $errorMessage = 'Gagal upload file: ' . $e->getMessage();
            
            // Pastikan catch juga mengembalikan JSON
            if ($request->wantsJson()) {
                return response()->json(['message' => $errorMessage], 500);
            }
            return back()->with('error', $errorMessage);
        }
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

    /**
     * Show all submissions for a specific user (admin and superadmin only)
     */
    public function showUserSubmissions(Request $request, User $user)
    {
        // Only admin and superadmin can access
        if (!in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized - Hanya admin dan superadmin yang dapat melihat detail submission user.');
        }

        $assignmentId = $request->query('assignment');
        
        $query = Submission::with(['assignment', 'user'])
            ->where('user_id', $user->id);
            
        if ($assignmentId) {
            $query->where('assignment_id', $assignmentId);
        }
        
        $submissions = $query->orderBy('created_at', 'desc')->get();

        return view('assignments.user-submissions', compact('user', 'submissions', 'assignmentId'));
    }
}
