<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageVideo;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomepageVideoController extends Controller
{
    /**
     * Display a listing of videos.
     */
    public function index(): View
    {
        $videos = HomepageVideo::ordered()->get();

        return view('admin.homepage-videos.index', compact('videos'));
    }

    /**
     * Show the form for creating new video.
     */
    public function create(): View
    {
        return view('admin.homepage-videos.create');
    }

    /**
     * Store a newly created video.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_type' => 'required|in:youtube,vimeo,local',
            'video_url' => 'required_unless:video_type,local|nullable|url',
            'video_file' => 'required_if:video_type,local|nullable|file|mimes:mp4,webm,mov|max:102400', // 100MB
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'title' => $validated['title'],
            'video_type' => $validated['video_type'],
        ];

        // Handle video URL or file
        if ($validated['video_type'] === 'local' && $request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/videos'), $filename);
            $data['video_url'] = $filename;
        } else {
            $data['video_url'] = $validated['video_url'];
        }

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            $thumb = $request->file('thumbnail');
            $thumbName = time() . '_' . $thumb->getClientOriginalName();
            $thumb->move(public_path('uploads/thumbnails'), $thumbName);
            $data['thumbnail_path'] = $thumbName;
        }

        // Get the next display order
        $maxOrder = HomepageVideo::max('display_order') ?? 0;
        $data['display_order'] = $maxOrder + 1;

        HomepageVideo::create($data);

        return redirect()->route('admin.homepage-videos.index')
            ->with('success', 'Video added successfully.');
    }

    /**
     * Show the form for editing video.
     */
    public function edit(HomepageVideo $homepageVideo): View
    {
        return view('admin.homepage-videos.edit', ['video' => $homepageVideo]);
    }

    /**
     * Update the specified video.
     */
    public function update(Request $request, HomepageVideo $homepageVideo): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_type' => 'required|in:youtube,vimeo,local',
            'video_url' => 'required_unless:video_type,local|nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,webm,mov|max:102400',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'title' => $validated['title'],
            'video_type' => $validated['video_type'],
        ];

        // Handle video URL or file
        if ($validated['video_type'] === 'local' && $request->hasFile('video_file')) {
            // Delete old file if local
            if ($homepageVideo->video_type === 'local') {
                $oldPath = public_path('uploads/videos/' . $homepageVideo->video_url);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('video_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/videos'), $filename);
            $data['video_url'] = $filename;
        } elseif ($validated['video_type'] !== 'local') {
            $data['video_url'] = $validated['video_url'];
        }

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($homepageVideo->thumbnail_path) {
                $oldThumb = public_path('uploads/thumbnails/' . $homepageVideo->thumbnail_path);
                if (file_exists($oldThumb)) {
                    unlink($oldThumb);
                }
            }

            $thumb = $request->file('thumbnail');
            $thumbName = time() . '_' . $thumb->getClientOriginalName();
            $thumb->move(public_path('uploads/thumbnails'), $thumbName);
            $data['thumbnail_path'] = $thumbName;
        }

        $homepageVideo->update($data);

        return redirect()->route('admin.homepage-videos.index')
            ->with('success', 'Video updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(HomepageVideo $homepageVideo): RedirectResponse
    {
        // If activating, deactivate all others first (only one shows at a time)
        if (!$homepageVideo->is_active) {
            HomepageVideo::where('id', '!=', $homepageVideo->id)->update(['is_active' => false]);
        }

        $homepageVideo->update(['is_active' => !$homepageVideo->is_active]);

        $message = $homepageVideo->is_active ? 'Video activated.' : 'Video deactivated.';
        return back()->with('success', $message);
    }

    /**
     * Delete video.
     */
    public function destroy(HomepageVideo $homepageVideo): RedirectResponse
    {
        // Delete video file if local
        if ($homepageVideo->video_type === 'local') {
            $path = public_path('uploads/videos/' . $homepageVideo->video_url);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // Delete thumbnail
        if ($homepageVideo->thumbnail_path) {
            $thumbPath = public_path('uploads/thumbnails/' . $homepageVideo->thumbnail_path);
            if (file_exists($thumbPath)) {
                unlink($thumbPath);
            }
        }

        $homepageVideo->delete();

        return back()->with('success', 'Video deleted successfully.');
    }
}
