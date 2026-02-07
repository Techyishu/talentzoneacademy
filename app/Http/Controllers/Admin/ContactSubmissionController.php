<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactSubmissionController extends Controller
{
    /**
     * Display a listing of contact submissions
     */
    public function index(Request $request)
    {
        $query = ContactSubmission::query()->orderBy('created_at', 'desc');

        // Filter by read status
        if ($request->filled('status')) {
            $isRead = $request->status === 'read';
            $query->where('is_read', $isRead);
        }

        // Search by name, email, or subject
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $submissions = $query->paginate(20);

        // Get unread count for badge
        $unreadCount = ContactSubmission::where('is_read', false)->count();

        return view('admin.contact-submissions.index', compact('submissions', 'unreadCount'));
    }

    /**
     * Display the specified contact submission
     */
    public function show(ContactSubmission $contactSubmission)
    {
        // Mark as read when viewing
        if (!$contactSubmission->is_read) {
            $contactSubmission->update(['is_read' => true]);
        }

        return view('admin.contact-submissions.show', compact('contactSubmission'));
    }

    /**
     * Remove the specified contact submission
     */
    public function destroy(ContactSubmission $contactSubmission)
    {
        $contactSubmission->delete();

        return redirect()->route('admin.contact-submissions.index')
            ->with('success', 'Contact submission deleted successfully.');
    }

    /**
     * Mark submission as read/unread
     */
    public function toggleRead(ContactSubmission $contactSubmission)
    {
        $contactSubmission->update(['is_read' => !$contactSubmission->is_read]);

        $status = $contactSubmission->is_read ? 'read' : 'unread';
        return back()->with('success', "Message marked as {$status}.");
    }

    /**
     * Bulk delete selected submissions
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contact_submissions,id',
        ]);

        $schoolId = session('active_school_id');
        $count = ContactSubmission::whereIn('id', $request->ids)
            ->where('school_id', $schoolId)
            ->delete();

        return back()->with('success', "Deleted {$count} contact " . Str::plural('submission', $count) . '.');
    }
}
