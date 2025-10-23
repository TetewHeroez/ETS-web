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
     * Import users from Excel file
     */
    public function import(Request $request)
    {
        $currentUser = auth()->user();
        
        // Only users with specific jabatan can import: Koor SC, Koor IC, SC
        $allowedJabatan = ['Koor SC', 'Koor IC', 'SC'];
        
        if (!in_array($currentUser->jabatan, $allowedJabatan)) {
            return redirect()->back()->with('error', 'Hanya Koor SC, Koor IC, dan SC yang dapat melakukan import data!');
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
     * Show the form for creating a new user (superadmin only)
     */
    public function create()
    {
        if (!auth()->user()->isSuperadmin()) {
            abort(403, 'Unauthorized');
        }

        return view('users.create');
    }

    /**
     * Store a newly created user (superadmin only)
     */
    public function store(Request $request)
    {
        if (!auth()->user()->isSuperadmin()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nrp' => 'nullable|string|max:20|unique:users',
            'role' => 'required|in:member,admin,superadmin',
            'jabatan' => 'required|in:PPH,SC,IC,OC,Koor SC,Koor IC',
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

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat!');
    }

    /**
     * Show the form for editing user with role-based permissions
     */
    public function edit(User $user)
    {
        $currentUser = auth()->user();
        
        // Superadmin can edit anyone
        if ($currentUser->isSuperadmin()) {
            return view('users.edit', compact('user'));
        }
        
        // Admin can only edit members
        if ($currentUser->isAdmin() && $user->role === 'member') {
            return view('users.edit', compact('user'));
        }
        
        // Otherwise, unauthorized
        abort(403, 'Unauthorized');
    }

    /**
     * Update user with role-based permissions
     */
    public function update(Request $request, User $user)
    {
        $currentUser = auth()->user();
        
        // Superadmin can update anyone
        if ($currentUser->isSuperadmin()) {
            // Allow all role changes for superadmin
        }
        // Admin can only update members
        elseif ($currentUser->isAdmin() && $user->role === 'member') {
            // Admin cannot change roles - restrict role field
        }
        // Otherwise, unauthorized
        else {
            abort(403, 'Unauthorized');
        }

        // Different validation rules based on user role
        if ($currentUser->isSuperadmin()) {
            // Superadmin can change everything including role
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'nrp' => 'nullable|string|max:20|unique:users,nrp,' . $user->id,
                'role' => 'required|in:member,admin,superadmin',
                'jabatan' => 'required|in:PPH,SC,IC,OC,Koor SC,Koor IC',
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
        } else {
            // Admin can only edit member data, not role
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'nrp' => 'nullable|string|max:20|unique:users,nrp,' . $user->id,
                'jabatan' => 'required|in:PPH,SC,IC,OC,Koor SC,Koor IC',
                'kelompok' => 'required|nullable|string|max:50', // Required for members
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
            
            // Force role to remain 'member' for admin edits
            $validated['role'] = 'member';
        }

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
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
        
        // Superadmin can delete anyone except themselves
        if ($currentUser->isSuperadmin()) {
            // Prevent deleting self
            if ($user->id === $currentUser->id) {
                return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri!');
            }
        }
        // Admin can only delete members
        elseif ($currentUser->isAdmin()) {
            if ($user->role !== 'member') {
                abort(403, 'Admin hanya dapat menghapus member!');
            }
        }
        // Members cannot delete anyone
        else {
            abort(403, 'Unauthorized');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', "User {$user->name} berhasil dihapus!");
    }

    /**
     * Toggle user status (aktif/nonaktif) with role-based permissions
     */
    public function toggleStatus(User $user)
    {
        $currentUser = auth()->user();
        
        // Superadmin can toggle anyone's status except themselves
        if ($currentUser->isSuperadmin()) {
            // Prevent toggling self
            if ($user->id === $currentUser->id) {
                return redirect()->back()->with('error', 'Tidak bisa menonaktifkan akun sendiri!');
            }
        }
        // Admin can only toggle members' status
        elseif ($currentUser->isAdmin()) {
            if ($user->role !== 'member') {
                abort(403, 'Admin hanya dapat menonaktifkan member!');
            }
        }
        // Members cannot toggle anyone's status
        else {
            abort(403, 'Unauthorized');
        }

        // Toggle status
        $newStatus = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->update(['status' => $newStatus]);

        $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('users.index')->with('success', "User {$user->name} berhasil {$statusText}!");
    }
}
