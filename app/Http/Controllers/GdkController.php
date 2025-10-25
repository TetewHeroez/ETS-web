<?php

namespace App\Http\Controllers;

use App\Models\GdkNilai;
use App\Models\GdkMateri;
use App\Models\GdkMetode;
use App\Models\GdkFlowchart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class GdkController extends Controller
{
    /**
     * Check if user has access to GDK features
     */
    private function checkAccess()
    {
        $allowedJabatan = ['Koor SC', 'Koor IC', 'SC'];
        $userJabatan = auth()->user()->jabatan ?? 'null';
        
        \Log::info('GDK Access Check', [
            'user_id' => auth()->id(),
            'user_jabatan' => $userJabatan,
            'allowed_jabatan' => $allowedJabatan,
            'has_access' => in_array($userJabatan, $allowedJabatan)
        ]);
        
        if (!in_array($userJabatan, $allowedJabatan)) {
            \Log::warning('GDK Access Denied', [
                'user_id' => auth()->id(),
                'user_jabatan' => $userJabatan
            ]);
            abort(403, 'Anda tidak memiliki akses ke halaman ini. Hanya Koor SC, Koor IC, dan SC yang dapat mengakses GDK.');
        }
    }

    /**
     * Display GDK index with nilai, materi, metode hierarchy and flowcharts
     */
    public function index()
    {
        $this->checkAccess();

        $nilais = GdkNilai::with(['materis.metodes'])
            ->orderBy('urutan')
            ->get();

        $flowcharts = GdkFlowchart::orderBy('urutan')->get();

        return view('gdk.index', compact('nilais', 'flowcharts'));
    }

    /**
     * Store a new Nilai
     */
    public function storeNilai(Request $request)
    {
        $this->checkAccess();

        $validated = $request->validate([
            'nama_nilai' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'multiplier' => 'required|numeric|min:0',
            'urutan' => 'required|integer|min:0',
        ]);

        // Set is_active to true by default
        $validated['is_active'] = true;

        GdkNilai::create($validated);

        return redirect()->route('gdk.index')->with('success', 'Nilai berhasil ditambahkan!');
    }

    /**
     * Update a Nilai
     */
    public function updateNilai(Request $request, GdkNilai $nilai)
    {
        $this->checkAccess();

        $validated = $request->validate([
            'nama_nilai' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'multiplier' => 'required|numeric|min:0',
            'urutan' => 'required|integer|min:0',
        ]);

        $nilai->update($validated);

        return redirect()->route('gdk.index')->with('success', 'Nilai berhasil diupdate!');
    }

    /**
     * Delete a Nilai
     */
    public function destroyNilai(GdkNilai $nilai)
    {
        $this->checkAccess();

        $nilai->delete();

        return redirect()->route('gdk.index')->with('success', 'Nilai berhasil dihapus!');
    }

    /**
     * Store a new Materi
     */
    public function storeMateri(Request $request)
    {
        $this->checkAccess();

        $validated = $request->validate([
            'gdk_nilai_id' => 'required|exists:gdk_nilai,id',
            'nama_materi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'multiplier' => 'required|numeric|min:0',
            'urutan' => 'required|integer|min:0',
        ]);

        // Set is_active to true by default
        $validated['is_active'] = true;

        GdkMateri::create($validated);

        return redirect()->route('gdk.index')->with('success', 'Materi berhasil ditambahkan!');
    }

    /**
     * Update a Materi
     */
    public function updateMateri(Request $request, GdkMateri $materi)
    {
        $this->checkAccess();

        $validated = $request->validate([
            'gdk_nilai_id' => 'required|exists:gdk_nilai,id',
            'nama_materi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'multiplier' => 'required|numeric|min:0',
            'urutan' => 'required|integer|min:0',
        ]);

        $materi->update($validated);

        return redirect()->route('gdk.index')->with('success', 'Materi berhasil diupdate!');
    }

    /**
     * Delete a Materi
     */
    public function destroyMateri(GdkMateri $materi)
    {
        $this->checkAccess();

        $materi->delete();

        return redirect()->route('gdk.index')->with('success', 'Materi berhasil dihapus!');
    }

    /**
     * Store a new Metode
     */
    public function storeMetode(Request $request)
    {
        $this->checkAccess();

        $validated = $request->validate([
            'gdk_materi_id' => 'required|exists:gdk_materi,id',
            'nama_metode' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'multiplier' => 'required|numeric|min:0',
            'pa' => 'nullable|string',
            'pi' => 'nullable|string',
            'urutan' => 'required|integer|min:0',
        ]);

        // Set is_active to true by default
        $validated['is_active'] = true;

        GdkMetode::create($validated);

        return redirect()->route('gdk.index')->with('success', 'Metode berhasil ditambahkan!');
    }

    /**
     * Update a Metode
     */
    public function updateMetode(Request $request, GdkMetode $metode)
    {
        $this->checkAccess();

        $validated = $request->validate([
            'gdk_materi_id' => 'required|exists:gdk_materi,id',
            'nama_metode' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'multiplier' => 'required|numeric|min:0',
            'pa' => 'nullable|string',
            'pi' => 'nullable|string',
            'urutan' => 'required|integer|min:0',
        ]);

        $metode->update($validated);

        return redirect()->route('gdk.index')->with('success', 'Metode berhasil diupdate!');
    }

    /**
     * Delete a Metode
     */
    public function destroyMetode(GdkMetode $metode)
    {
        $this->checkAccess();

        $metode->delete();

        return redirect()->route('gdk.index')->with('success', 'Metode berhasil dihapus!');
    }

    /**
     * Store a new Flowchart
     */
    public function storeFlowchart(Request $request)
    {
        try {
            // Log request data BEFORE everything
            \Log::info('storeFlowchart: Request received', [
                'has_image' => $request->hasFile('image'),
                'image_field_exists' => $request->has('image'),
                'all_keys' => array_keys($request->all()),
                'content_type' => $request->header('Content-Type')
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                \Log::info('storeFlowchart: File details', [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'is_valid' => $file->isValid(),
                    'error' => $file->getError(),
                    'real_path' => $file->getRealPath()
                ]);
            } else {
                \Log::warning('storeFlowchart: No file detected in request');
            }

            $this->checkAccess();

            $validated = $request->validate([
                'judul' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:5120',
                'urutan' => 'required|integer|min:0',
            ]);

            \Log::info('Flowchart upload validation passed', ['judul' => $validated['judul']]);

            // Upload image ke Cloudinary
            if ($request->hasFile('image')) {
                try {
                    $file = $request->file('image');
                    \Log::info('Uploading flowchart to Cloudinary', [
                        'file_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                        'real_path' => $file->getRealPath()
                    ]);

                    $uploadedFile = Cloudinary::uploadApi()->upload($file->getRealPath(), [
                        'folder' => 'myhimatika/flowcharts',
                        'resource_type' => 'auto',
                        'transformation' => [
                            'quality' => 'auto',
                            'fetch_format' => 'auto'
                        ]
                    ]);

                    \Log::info('Flowchart uploaded to Cloudinary', ['response_type' => gettype($uploadedFile)]);

                    // Extract secure URL - ApiResponse supports both array and object access
                    $imagePath = null;
                    try {
                        // Try array access first (for ArrayAccess interface)
                        if (isset($uploadedFile['secure_url'])) {
                            $imagePath = $uploadedFile['secure_url'];
                        } elseif (isset($uploadedFile['url'])) {
                            $imagePath = $uploadedFile['url'];
                        } elseif (is_object($uploadedFile)) {
                            // Try object property access
                            if (property_exists($uploadedFile, 'secure_url') && !empty($uploadedFile->secure_url)) {
                                $imagePath = $uploadedFile->secure_url;
                            } elseif (property_exists($uploadedFile, 'url') && !empty($uploadedFile->url)) {
                                $imagePath = $uploadedFile->url;
                            }
                        }
                    } catch (\Exception $e) {
                        \Log::error('Error accessing URL from response', ['error' => $e->getMessage()]);
                    }

                    if (!$imagePath) {
                        \Log::error('No URL found in Cloudinary response', [
                            'response' => print_r($uploadedFile, true),
                            'response_type' => gettype($uploadedFile),
                            'class' => is_object($uploadedFile) ? get_class($uploadedFile) : 'not_object'
                        ]);
                        return response()->json(['success' => false, 'message' => 'Cloudinary upload gagal: tidak ada URL'], 400);
                    }

                    $validated['image_path'] = $imagePath;
                    \Log::info('Image path extracted', ['path' => $imagePath]);
                } catch (\Exception $e) {
                    \Log::error('Cloudinary upload exception', [
                        'error' => $e->getMessage(),
                        'class' => get_class($e),
                        'trace' => $e->getTraceAsString()
                    ]);
                    return response()->json(['success' => false, 'message' => 'Gagal upload ke Cloudinary: ' . $e->getMessage()], 400);
                }
            } else {
                \Log::error('No image file in request');
                return response()->json(['success' => false, 'message' => 'Tidak ada file yang diunggah'], 400);
            }

            unset($validated['image']);
            
            // Set is_active to true by default
            $validated['is_active'] = true;
            
            \Log::info('Creating flowchart in database', ['validated_data' => array_keys($validated)]);
            
            $flowchart = GdkFlowchart::create($validated);
            
            \Log::info('Flowchart created successfully', ['id' => $flowchart->id, 'judul' => $flowchart->judul]);
            
            return response()->json(['success' => true, 'message' => 'Flowchart berhasil ditambahkan!', 'data' => $flowchart]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Flowchart validation failed', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'message' => 'Validation error: ' . json_encode($e->errors())], 422);
        } catch (\Exception $e) {
            \Log::error('Unexpected error in storeFlowchart', [
                'error' => $e->getMessage(),
                'class' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Update a Flowchart
     */
    public function updateFlowchart(Request $request, GdkFlowchart $flowchart)
    {
        try {
            $this->checkAccess();

            \Log::info('updateFlowchart: Request received', [
                'has_image' => $request->hasFile('image'),
                'image_field_exists' => $request->has('image'),
                'all_keys' => array_keys($request->all()),
                'content_type' => $request->header('Content-Type')
            ]);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                \Log::info('updateFlowchart: File details', [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'is_valid' => $file->isValid(),
                    'error' => $file->getError(),
                    'real_path' => $file->getRealPath()
                ]);
            } else {
                \Log::warning('updateFlowchart: No file detected in request');
            }

            $validated = $request->validate([
                'judul' => 'nullable|string|max:255',
                'deskripsi' => 'nullable|string',
                'urutan' => 'nullable|integer|min:0',
            ]);

            // Validate image separately if provided
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'mimes:jpeg,png,jpg,gif,svg|max:5120',
                ]);
            }

            \Log::info('updateFlowchart: After validation');

            // Upload new image ke Cloudinary if provided
            if ($request->hasFile('image')) {
                try {
                    // Delete old image dari Cloudinary jika ada
                    if ($flowchart->image_path) {
                        try {
                            // Extract public_id dari URL Cloudinary
                            if (preg_match('/\/myhimatika\/flowcharts\/([^\.]+)/', $flowchart->image_path, $matches)) {
                                $publicId = 'myhimatika/flowcharts/' . $matches[1];
                                Cloudinary::uploadApi()->destroy($publicId);
                                \Log::info('Old flowchart deleted from Cloudinary', ['public_id' => $publicId]);
                            }
                        } catch (\Exception $e) {
                            \Log::warning('Failed to delete old flowchart from Cloudinary: ' . $e->getMessage());
                        }
                    }

                    // Upload image baru
                    \Log::info('Uploading updated flowchart to Cloudinary', [
                        'flowchart_id' => $flowchart->id,
                        'file_name' => $request->file('image')->getClientOriginalName()
                    ]);

                    $uploadedFile = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
                        'folder' => 'myhimatika/flowcharts',
                        'transformation' => [
                            'quality' => 'auto',
                            'fetch_format' => 'auto'
                        ]
                    ]);

                    // Extract secure URL - ApiResponse supports both array and object access
                    $imagePath = null;
                    try {
                        // Try array access first (for ArrayAccess interface)
                        if (isset($uploadedFile['secure_url'])) {
                            $imagePath = $uploadedFile['secure_url'];
                        } elseif (isset($uploadedFile['url'])) {
                            $imagePath = $uploadedFile['url'];
                        } elseif (is_object($uploadedFile)) {
                            // Try object property access
                            if (property_exists($uploadedFile, 'secure_url') && !empty($uploadedFile->secure_url)) {
                                $imagePath = $uploadedFile->secure_url;
                            } elseif (property_exists($uploadedFile, 'url') && !empty($uploadedFile->url)) {
                                $imagePath = $uploadedFile->url;
                            }
                        }
                    } catch (\Exception $e) {
                        \Log::error('Error accessing URL from response', ['error' => $e->getMessage()]);
                    }

                    if (!$imagePath) {
                        \Log::error('No URL in Cloudinary response for updated flowchart');
                        return response()->json(['success' => false, 'message' => 'Cloudinary upload gagal: tidak ada URL'], 400);
                    }

                    $validated['image_path'] = $imagePath;
                    \Log::info('Updated flowchart image path set', ['path' => $imagePath]);
                } catch (\Exception $e) {
                    \Log::error('Failed to upload updated flowchart', [
                        'error' => $e->getMessage(),
                        'class' => get_class($e)
                    ]);
                    return response()->json(['success' => false, 'message' => 'Gagal upload ke Cloudinary: ' . $e->getMessage()], 400);
                }
            }

            unset($validated['image']);
            $flowchart->update($validated);

            \Log::info('Flowchart updated successfully', ['id' => $flowchart->id]);

            return response()->json(['success' => true, 'message' => 'Flowchart berhasil diupdate!', 'data' => $flowchart]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Flowchart update validation failed', ['errors' => $e->errors()]);
            return response()->json(['success' => false, 'message' => 'Validation error'], 422);
        } catch (\Exception $e) {
            \Log::error('Unexpected error in updateFlowchart', [
                'error' => $e->getMessage(),
                'class' => get_class($e),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete a Flowchart
     */
    public function destroyFlowchart(GdkFlowchart $flowchart)
    {
        $this->checkAccess();

        try {
            // Delete image from Cloudinary
            if ($flowchart->image_path) {
                try {
                    if (preg_match('/\/myhimatika\/flowcharts\/([^\.]+)/', $flowchart->image_path, $matches)) {
                        $publicId = 'myhimatika/flowcharts/' . $matches[1];
                        Cloudinary::uploadApi()->destroy($publicId);
                        \Log::info('Flowchart deleted from Cloudinary', ['public_id' => $publicId]);
                    }
                } catch (\Exception $e) {
                    \Log::warning('Failed to delete flowchart from Cloudinary: ' . $e->getMessage());
                }
            }

            $flowchart->delete();
            \Log::info('Flowchart deleted from database', ['id' => $flowchart->id]);

            // Return JSON if request is AJAX/fetch
            if (request()->wantsJson()) {
                return response()->json(['message' => 'Flowchart berhasil dihapus!'], 200);
            }

            return redirect()->route('gdk.index')->with('success', 'Flowchart berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Failed to delete flowchart', ['error' => $e->getMessage()]);
            
            // Return JSON if request is AJAX/fetch
            if (request()->wantsJson()) {
                return response()->json(['message' => 'Gagal menghapus flowchart: ' . $e->getMessage()], 500);
            }

            return redirect()->route('gdk.index')->with('error', 'Gagal menghapus flowchart: ' . $e->getMessage());
        }
    }
}
