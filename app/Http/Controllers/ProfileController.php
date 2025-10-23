<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                'no_hp' => 'nullable|string|max:20',
                'password' => 'nullable|string|min:8|confirmed',
            ]);
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
}
