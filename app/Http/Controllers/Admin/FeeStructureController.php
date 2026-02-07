<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\FeeHead;
use App\Models\FeeStructure;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeStructureController extends Controller
{
    /**
     * Display the fee structure management page.
     */
    public function index(Request $request)
    {
        $sessions = AcademicSession::orderBy('start_date', 'desc')->get();
        $selectedSessionId = $request->get('session_id', session('active_session_id'));
        $selectedSession = AcademicSession::find($selectedSessionId);

        if (!$selectedSession && $sessions->count() > 0) {
            $selectedSession = $sessions->first();
            $selectedSessionId = $selectedSession->id;
        }

        $classes = SchoolClass::orderBy('display_order')->orderBy('name')->get();
        $feeHeads = FeeHead::active()->orderBy('name')->get();

        // Get existing fee structures for the selected session
        $feeStructures = [];
        if ($selectedSessionId) {
            $structures = FeeStructure::where('academic_session_id', $selectedSessionId)
                ->get();

            foreach ($structures as $structure) {
                $feeStructures[$structure->class_id][$structure->fee_head_id] = $structure;
            }
        }

        return view('admin.fee-structures.index', compact(
            'sessions',
            'selectedSession',
            'classes',
            'feeHeads',
            'feeStructures'
        ));
    }

    /**
     * Update fee structures in bulk.
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:academic_sessions,id',
            'structures' => 'required|array',
            'structures.*.class_id' => 'required|exists:classes,id',
            'structures.*.fee_head_id' => 'required|exists:fee_heads,id',
            'structures.*.amount' => 'required|numeric|min:0',
            'structures.*.frequency' => 'required|in:monthly,quarterly,annual',
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['structures'] as $structureData) {
                if ($structureData['amount'] > 0) {
                    FeeStructure::updateOrCreate(
                        [
                            'school_id' => session('active_school_id'),
                            'academic_session_id' => $validated['session_id'],
                            'class_id' => $structureData['class_id'],
                            'fee_head_id' => $structureData['fee_head_id'],
                        ],
                        [
                            'amount' => $structureData['amount'],
                            'frequency' => $structureData['frequency'],
                        ]
                    );
                } else {
                    // Remove if amount is zero
                    FeeStructure::where([
                        'school_id' => session('active_school_id'),
                        'academic_session_id' => $validated['session_id'],
                        'class_id' => $structureData['class_id'],
                        'fee_head_id' => $structureData['fee_head_id'],
                    ])->delete();
                }
            }
        });

        return redirect()
            ->route('fee-structures.index', ['session_id' => $validated['session_id']])
            ->with('success', 'Fee structures updated successfully.');
    }

    /**
     * Clone fee structures from a previous session.
     */
    public function clone(Request $request)
    {
        $validated = $request->validate([
            'from_session_id' => 'required|exists:academic_sessions,id',
            'to_session_id' => 'required|exists:academic_sessions,id|different:from_session_id',
        ]);

        $fromSession = AcademicSession::findOrFail($validated['from_session_id']);
        $toSession = AcademicSession::findOrFail($validated['to_session_id']);

        // Check if target session already has fee structures
        $existingCount = FeeStructure::where('academic_session_id', $toSession->id)->count();

        if ($existingCount > 0 && !$request->has('overwrite')) {
            return redirect()
                ->route('fee-structures.index', ['session_id' => $toSession->id])
                ->with('error', "Target session already has {$existingCount} fee structure(s). Use overwrite option to replace them.");
        }

        DB::transaction(function () use ($fromSession, $toSession, $request) {
            // Delete existing structures if overwrite is enabled
            if ($request->has('overwrite')) {
                FeeStructure::where('academic_session_id', $toSession->id)->delete();
            }

            // Copy structures from previous session
            $sourceStructures = FeeStructure::where('academic_session_id', $fromSession->id)->get();

            foreach ($sourceStructures as $source) {
                FeeStructure::create([
                    'school_id' => $source->school_id,
                    'academic_session_id' => $toSession->id,
                    'class_id' => $source->class_id,
                    'fee_head_id' => $source->fee_head_id,
                    'amount' => $source->amount,
                    'frequency' => $source->frequency,
                ]);
            }
        });

        return redirect()
            ->route('fee-structures.index', ['session_id' => $toSession->id])
            ->with('success', "Successfully cloned {$fromSession->name} fee structures to {$toSession->name}.");
    }
}
