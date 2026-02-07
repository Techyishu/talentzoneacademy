<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublicReview;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PublicReviewController extends Controller
{
    /**
     * Display a listing of reviews.
     */
    public function index(Request $request): View
    {
        $status = $request->get('status', 'all');

        $query = PublicReview::with('school')->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $reviews = $query->paginate(15);

        $counts = [
            'all' => PublicReview::count(),
            'pending' => PublicReview::pending()->count(),
            'approved' => PublicReview::approved()->count(),
            'rejected' => PublicReview::rejected()->count(),
        ];

        return view('admin.public-reviews.index', compact('reviews', 'status', 'counts'));
    }

    /**
     * Show a single review.
     */
    public function show(PublicReview $publicReview): View
    {
        return view('admin.public-reviews.show', ['review' => $publicReview]);
    }

    /**
     * Approve a review.
     */
    public function approve(PublicReview $publicReview): RedirectResponse
    {
        $publicReview->update(['status' => 'approved']);

        return back()->with('success', 'Review approved successfully.');
    }

    /**
     * Reject a review.
     */
    public function reject(PublicReview $publicReview): RedirectResponse
    {
        $publicReview->update(['status' => 'rejected']);

        return back()->with('success', 'Review rejected.');
    }

    /**
     * Delete a review.
     */
    public function destroy(PublicReview $publicReview): RedirectResponse
    {
        $publicReview->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
}
