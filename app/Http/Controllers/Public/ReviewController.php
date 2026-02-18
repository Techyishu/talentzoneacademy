<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\PublicReview;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    /**
     * Store a new public review.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'reviewer_name' => 'required|string|max:255',
            'reviewer_email' => 'nullable|email|max:255',
            'content' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'school_id' => 'nullable|exists:schools,id',
        ]);

        $validated['status'] = 'pending';

        PublicReview::create($validated);

        return back()->with('review_success', 'Thank you for your review! It will be displayed after approval.');
    }
}
