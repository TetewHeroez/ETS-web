<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProfileController extends Controller
{
    /**
     * Tampilkan profil user
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    /**
     * Tampilkan form edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi berbeda berdasarkan role
        if ($user->role === 'member') {
            // Member bisa edit semua field
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'nrp' => 'nullable|string|max:20|unique:users,nrp,' . $user->id,
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'no_hp' => 'nullable|string|max:20',
                'kelompok' => 'nullable|string|max:50',
                'hobi' => 'nullable|string',
                'tempat_lahir' => 'nullable|string|max:255',
                'tanggal_lahir' => 'nullable|date',
                'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
                'alamat_asal' => 'nullable|string',
                'alamat_surabaya' => 'nullable|string',
                'nama_ortu' => 'nullable|string|max:255',
                'alamat_ortu' => 'nullable|string',
                'no_hp_ortu' => 'nullable|string|max:20',
                'golongan_darah' => 'nullable|string|max:5',
                'alergi' => 'nullable|string',
                'riwayat_penyakit' => 'nullable|string',
                'password' => 'nullable|string|min:8|confirmed',
            ]);
        } else {
            // Admin & Superadmin hanya bisa edit field terbatas
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'nrp' => 'nullable|string|max:20|unique:users,nrp,' . $user->id,
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'no_hp' => 'nullable|string|max:20',
                'password' => 'nullable|string|min:8|confirmed',
            ]);
        }

        // Handle foto profil
        if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
            \Log::info('Profile photo upload started', [
                'user_id' => $user->id,
                'file_name' => $request->file('profile_photo')->getClientOriginalName(),
                'file_size' => $request->file('profile_photo')->getSize(),
                'mime_type' => $request->file('profile_photo')->getMimeType()
            ]);

            // Hapus foto lama dari Cloudinary jika ada
            if ($user->profile_photo) {
                try {
                    // Extract public_id dari URL Cloudinary
                    $publicId = $this->extractPublicId($user->profile_photo);
                    if ($publicId) {
                        Cloudinary::uploadApi()->destroy($publicId);
                        \Log::info('Old profile photo deleted from Cloudinary', ['public_id' => $publicId]);
                    }
                } catch (\Exception $e) {
                    // Lanjutkan meskipun gagal hapus foto lama
                    \Log::warning('Failed to delete old profile photo from Cloudinary: ' . $e->getMessage());
                }
            }
            
            // Upload foto baru ke Cloudinary
            try {
                // Test Cloudinary config first
                $cloudName = config('cloudinary.cloud_name');
                $apiKey = config('cloudinary.api_key');
                $apiSecret = config('cloudinary.api_secret');
                
                if (empty($cloudName) || empty($apiKey) || empty($apiSecret)) {
                    throw new \Exception('Cloudinary configuration not found. Please check your .env file.');
                }
                
                \Log::info('Cloudinary config loaded', [
                    'cloud_name' => $cloudName,
                    'api_key' => substr($apiKey, 0, 4) . '...'
                ]);
                
                $uploadedFile = Cloudinary::uploadApi()->upload($request->file('profile_photo')->getRealPath(), [
                    'folder' => 'myhimatika/profile_photos',
                    'transformation' => [
                        'width' => 500,
                        'height' => 500,
                        'crop' => 'fill',
                        'quality' => 'auto',
                        'fetch_format' => 'auto'
                    ]
                ]);
                
                // Check if upload successful
                if (!$uploadedFile) {
                    throw new \Exception('Upload failed: No response from Cloudinary');
                }
                
                // Log the ENTIRE response structure for debugging
                $responseString = json_encode($uploadedFile, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                \Log::info('FULL Cloudinary response: ' . $responseString);
                \Log::info('Response type: ' . gettype($uploadedFile));
                
                // Handle different response types (array or object)
                $securePath = null;
                if (is_array($uploadedFile)) {
                    \Log::info('Response is array with keys: ' . json_encode(array_keys($uploadedFile)));
                    $securePath = $uploadedFile['secure_url'] ?? $uploadedFile['url'] ?? null;
                } elseif (is_object($uploadedFile)) {
                    \Log::info('Response is object of class: ' . get_class($uploadedFile));
                    // Try array access for ArrayAccess interface
                    if ($uploadedFile instanceof \ArrayAccess) {
                        $securePath = $uploadedFile['secure_url'] ?? $uploadedFile['url'] ?? null;
                    } else {
                        // Regular object properties
                        $securePath = $uploadedFile->secure_url ?? $uploadedFile->url ?? null;
                    }
                    
                    // Try method call if property doesn't exist
                    if (!$securePath && method_exists($uploadedFile, 'getSecurePath')) {
                        $securePath = $uploadedFile->getSecurePath();
                    }
                }
                
                \Log::info('Extracted secure path: ' . ($securePath ?? 'NULL'));
                
                if (empty($securePath)) {
                    throw new \Exception('Upload failed: No secure URL found. Full response: ' . $responseString);
                }
                
                $validated['profile_photo'] = $securePath;
                \Log::info('Profile photo uploaded successfully to Cloudinary', [
                    'user_id' => $user->id,
                    'cloudinary_url' => $validated['profile_photo']
                ]);
            } catch (\Exception $e) {
                // Log error dan lanjutkan tanpa update foto
                \Log::error('Failed to upload profile photo to Cloudinary', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                return redirect()->back()->withErrors(['profile_photo' => 'Gagal upload foto ke Cloudinary: ' . $e->getMessage()])->withInput();
            }
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Extract public_id dari URL Cloudinary
     */
    private function extractPublicId($url)
    {
        if (empty($url)) {
            return null;
        }

        // Format URL Cloudinary: https://res.cloudinary.com/{cloud_name}/image/upload/{transformations}/{public_id}.{format}
        if (preg_match('/\/myhimatika\/profile_photos\/([^\.]+)/', $url, $matches)) {
            return 'myhimatika/profile_photos/' . $matches[1];
        }

        return null;
    }
}
