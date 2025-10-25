<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;

class UserController extends Controller
{
    /**
     * Display a listing of users with optional search.
     */
    public function index(Request $request)
    {
        // Only admin and superadmin should manage users
        if (!auth()->user()->isAdmin() && !auth()->user()->isSuperadmin()) {
            abort(403, 'Unauthorized');
        }

        $query = User::query();

        // Member role can only see active users
        // Admin and superadmin can see all users
        $currentUser = auth()->user();
        if ($currentUser->role === 'member') {
            $query->where('status', 'aktif');
        }

        // Optional role filter (member/admin/superadmin)
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        // Search by name or nrp (case-insensitive)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nrp', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        
        // Validate sort column to prevent SQL injection
        $allowedSorts = ['name', 'email', 'nrp', 'jabatan', 'kelompok', 'status', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'name';
        }

        $users = $query->orderBy($sortBy, $sortOrder)->paginate(20)->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Import users from Excel file (SuperAdmin only)
     */
    public function import(Request $request)
    {
        $currentUser = auth()->user();
        
        // Only superadmin can import
        if (!$currentUser->isSuperadmin()) {
            return redirect()->back()->with('error', 'Hanya SuperAdmin yang dapat melakukan import data!');
        }

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new UsersImport, $request->file('file'));
            
            return redirect()->route('users.index')->with('success', 'Data member berhasil diimport dari Excel!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new user
     * SuperAdmin: Can create any role
     * Admin: Can only create member
     */
    public function create()
    {
        $currentUser = auth()->user();
        
        if (!$currentUser->isAdmin() && !$currentUser->isSuperadmin()) {
            abort(403, 'Unauthorized');
        }

        return view('users.create');
    }

    /**
     * Store a newly created user
     * SuperAdmin: Can create any role
     * Admin: Can only create member
     */
    public function store(Request $request)
    {
        $currentUser = auth()->user();
        
        if (!$currentUser->isAdmin() && !$currentUser->isSuperadmin()) {
            abort(403, 'Unauthorized');
        }

        // Admin can only create member
        if ($currentUser->isAdmin() && $request->role !== 'member') {
            return redirect()->back()->with('error', 'Admin hanya dapat membuat user dengan role Member!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nrp' => 'nullable|string|max:20|unique:users',
            'role' => 'required|in:member,admin,superadmin',
            'jabatan' => 'required|in:PPH,PJ,SC,IC,OC,SRD,Koor SC,Koor IC,Koor OC',
            'pj_number' => 'required_if:jabatan,PJ|nullable|integer|min:0',
            'kelompok' => 'required_if:role,member|nullable|string|max:50',
            'password' => 'required|string|min:8',
            'hobi' => 'nullable|string',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'alamat_asal' => 'nullable|string',
            'alamat_surabaya' => 'nullable|string',
            'nama_ortu' => 'nullable|string|max:255',
            'alamat_ortu' => 'nullable|string',
            'no_hp_ortu' => 'nullable|string|max:20',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        // Set pj_number to null if jabatan is not PJ
        if ($validated['jabatan'] !== 'PJ') {
            $validated['pj_number'] = null;
        }

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat!');
    }

    /**
     * Show the form for editing user (SuperAdmin only)
     */
    public function edit(User $user)
    {
        $currentUser = auth()->user();
        
        // Only superadmin can edit users
        if (!$currentUser->isSuperadmin()) {
            abort(403, 'Unauthorized - Hanya SuperAdmin yang dapat mengedit user');
        }
        
        return view('users.edit', compact('user'));
    }

    /**
     * Update user (SuperAdmin only)
     */
    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();
        
        // Only superadmin can update users
        if (!$currentUser->isSuperadmin()) {
            abort(403, 'Unauthorized - Hanya SuperAdmin yang dapat mengedit user');
        }

        // Superadmin can change everything including role
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nrp' => 'nullable|string|max:20|unique:users,nrp,' . $user->id,
            'role' => 'required|in:member,admin,superadmin',
            'jabatan' => 'required|in:PPH,PJ,SC,IC,OC,SRD,Koor SC,Koor IC,Koor OC',
            'pj_number' => 'required_if:jabatan,PJ|nullable|integer|min:0',
            'kelompok' => 'required_if:role,member|nullable|string|max:50',
            'password' => 'nullable|string|min:8',
            'hobi' => 'nullable|string',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'alamat_asal' => 'nullable|string',
            'alamat_surabaya' => 'nullable|string',
            'nama_ortu' => 'nullable|string|max:255',
            'alamat_ortu' => 'nullable|string',
            'no_hp_ortu' => 'nullable|string|max:20',
            'no_hp' => 'nullable|string|max:20',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Set pj_number to null if jabatan is not PJ
        if ($validated['jabatan'] !== 'PJ') {
            $validated['pj_number'] = null;
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate!');
    }

    /**
     * Delete user with role-based permissions
     */
    public function destroy(User $user)
    {
        $currentUser = auth()->user();
        
        // Only superadmin can delete users
        if (!$currentUser->isSuperadmin()) {
            abort(403, 'Unauthorized - Hanya SuperAdmin yang dapat menghapus user');
        }
        
        // Prevent deleting self
        if ($user->id === $currentUser->id) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', "User {$user->name} berhasil dihapus!");
    }

    /**
     * Toggle user status (aktif/nonaktif) - superadmin only
     */
    public function toggleStatus(User $user)
    {
        $currentUser = auth()->user();
        
        // Only superadmin can toggle user status
        if (!$currentUser->isSuperadmin()) {
            abort(403, 'Unauthorized - Hanya SuperAdmin yang dapat mengubah status user');
        }
        
        // Prevent toggling self
        if ($user->id === $currentUser->id) {
            return redirect()->back()->with('error', 'Tidak bisa menonaktifkan akun sendiri!');
        }

        // Toggle status
        $newStatus = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->update(['status' => $newStatus]);

        $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('users.index')->with('success', "User {$user->name} berhasil {$statusText}!");
    }
}
