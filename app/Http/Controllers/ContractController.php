<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use Illuminate\Http\Request;

class ContractController extends Controller
{
    /**
     * Check if user has access (Koor SC, Koor IC, SC only)
     */
    private function checkAccess()
    {
        $user = auth()->user();
        $allowedJabatan = ['Koor SC', 'Koor IC', 'SC'];
        
        if (!in_array($user->jabatan, $allowedJabatan)) {
            abort(403, 'Unauthorized - Hanya Koor SC, Koor IC, dan SC yang dapat mengakses halaman ini.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->checkAccess();
        $contracts = Contract::orderBy('created_at', 'desc')->get();
        return view('contracts.index', compact('contracts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contract $contract)
    {
        $this->checkAccess();
        return view('contracts.edit', compact('contract'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contract $contract)
    {
        $this->checkAccess();
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rules' => 'required|array|min:1',
            'rules.*' => 'required|string'
        ]);

        $contract->update($validated);

        return redirect()->route('contracts.index')
            ->with('success', 'Kontrak berhasil diupdate!');
    }
}
