<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeHead;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeeHeadController extends Controller
{
    /**
     * Display a listing of the fee heads.
     */
    public function index()
    {
        $feeHeads = FeeHead::orderBy('name')->get();

        return view('admin.fee-heads.index', compact('feeHeads'));
    }

    /**
     * Show the form for creating a new fee head.
     */
    public function create()
    {
        return view('admin.fee-heads.create');
    }

    /**
     * Store a newly created fee head in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fee_heads', 'name')->where('school_id', session('active_school_id')),
            ],
            'code' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        FeeHead::create($validated);

        return redirect()
            ->route('fee-heads.index')
            ->with('success', 'Fee head created successfully.');
    }

    /**
     * Show the form for editing the specified fee head.
     */
    public function edit(FeeHead $feeHead)
    {
        return view('admin.fee-heads.edit', compact('feeHead'));
    }

    /**
     * Update the specified fee head in storage.
     */
    public function update(Request $request, FeeHead $feeHead)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fee_heads', 'name')
                    ->where('school_id', session('active_school_id'))
                    ->ignore($feeHead->id),
            ],
            'code' => 'nullable|string|max:10',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $feeHead->update($validated);

        return redirect()
            ->route('fee-heads.index')
            ->with('success', 'Fee head updated successfully.');
    }

    /**
     * Remove the specified fee head from storage.
     */
    public function destroy(FeeHead $feeHead)
    {
        // Check if fee head is used in fee structures
        if ($feeHead->feeStructures()->count() > 0) {
            return redirect()
                ->route('fee-heads.index')
                ->with('error', 'Cannot delete fee head that is used in fee structures.');
        }

        $feeHead->delete();

        return redirect()
            ->route('fee-heads.index')
            ->with('success', 'Fee head deleted successfully.');
    }

    /**
     * Toggle the active status of the fee head.
     */
    public function toggleStatus(FeeHead $feeHead)
    {
        $feeHead->is_active = !$feeHead->is_active;
        $feeHead->save();

        $status = $feeHead->is_active ? 'activated' : 'deactivated';

        return redirect()
            ->route('fee-heads.index')
            ->with('success', "Fee head {$status} successfully.");
    }
}
