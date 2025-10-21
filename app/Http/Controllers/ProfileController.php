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

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nrp' => 'required|string|max:20|unique:users,nrp,' . $user->id,
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'alamat_asal' => 'nullable|string',
            'alamat_surabaya' => 'nullable|string',
            'nama_ortu' => 'nullable|string|max:255',
            'alamat_ortu' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'golongan_darah' => 'nullable|string|max:5',
            'alergi' => 'nullable|string',
            'riwayat_penyakit' => 'nullable|string',
        ]);

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui!');
    }
}
