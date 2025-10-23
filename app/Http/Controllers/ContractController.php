<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin() && !Auth::user()->isSuperAdmin()) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contracts = Contract::orderBy('created_at', 'desc')->get();
        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contracts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rules' => 'required|array|min:1',
            'rules.*' => 'required|string',
            'is_active' => 'boolean'
        ]);

        // If this contract is set as active, deactivate all others
        if ($request->is_active) {
            Contract::where('is_active', true)->update(['is_active' => false]);
        }

        Contract::create($validated);

        return redirect()->route('contracts.index')
            ->with('success', 'Kontrak berhasil dibuat!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        return view('contracts.edit', compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rules' => 'required|array|min:1',
            'rules.*' => 'required|string',
            'is_active' => 'boolean'
        ]);

        // If this contract is set as active, deactivate all others
        if ($request->is_active) {
            Contract::where('id', '!=', $contract->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $contract->update($validated);

        return redirect()->route('contracts.index')
            ->with('success', 'Kontrak berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contract $contract)
    {
        $contract->delete();

        return redirect()->route('contracts.index')
            ->with('success', 'Kontrak berhasil dihapus!');
    }

    /**
     * Toggle contract active status
     */
    public function toggleActive(Contract $contract)
    {
        // Deactivate all contracts first
        Contract::where('is_active', true)->update(['is_active' => false]);
        
        // Activate this contract
        $contract->update(['is_active' => true]);

        return redirect()->route('contracts.index')
            ->with('success', 'Kontrak berhasil diaktifkan!');
    }
}
