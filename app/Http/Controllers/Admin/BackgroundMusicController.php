<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackgroundMusic;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class BackgroundMusicController extends Controller
{
    /**
     * Display a listing of music.
     */
    public function index(): View
    {
        $music = BackgroundMusic::ordered()->get();

        return view('admin.background-music.index', compact('music'));
    }

    /**
     * Show the form for creating new music.
     */
    public function create(): View
    {
        return view('admin.background-music.create');
    }

    /**
     * Store a newly created music.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'audio_file' => 'required|file|mimes:mp3,wav,ogg|max:20480', // 20MB max
        ]);

        // Handle file upload
        $file = $request->file('audio_file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/music'), $filename);

        // Get the next display order
        $maxOrder = BackgroundMusic::max('display_order') ?? 0;

        BackgroundMusic::create([
            'title' => $validated['title'],
            'file_path' => $filename,
            'display_order' => $maxOrder + 1,
        ]);

        return redirect()->route('admin.background-music.index')
            ->with('success', 'Music added successfully.');
    }

    /**
     * Show the form for editing music.
     */
    public function edit(BackgroundMusic $backgroundMusic): View
    {
        return view('admin.background-music.edit', ['music' => $backgroundMusic]);
    }

    /**
     * Update the specified music.
     */
    public function update(Request $request, BackgroundMusic $backgroundMusic): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'audio_file' => 'nullable|file|mimes:mp3,wav,ogg|max:20480',
        ]);

        $data = ['title' => $validated['title']];

        if ($request->hasFile('audio_file')) {
            // Delete old file
            $oldPath = public_path('uploads/music/' . $backgroundMusic->file_path);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }

            // Upload new file
            $file = $request->file('audio_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/music'), $filename);
            $data['file_path'] = $filename;
        }

        $backgroundMusic->update($data);

        return redirect()->route('admin.background-music.index')
            ->with('success', 'Music updated successfully.');
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(BackgroundMusic $backgroundMusic): RedirectResponse
    {
        // If activating, deactivate all others first (only one can be active)
        if (!$backgroundMusic->is_active) {
            BackgroundMusic::where('id', '!=', $backgroundMusic->id)->update(['is_active' => false]);
        }

        $backgroundMusic->update(['is_active' => !$backgroundMusic->is_active]);

        $message = $backgroundMusic->is_active ? 'Music activated.' : 'Music deactivated.';
        return back()->with('success', $message);
    }

    /**
     * Delete music.
     */
    public function destroy(BackgroundMusic $backgroundMusic): RedirectResponse
    {
        // Delete file
        $path = public_path('uploads/music/' . $backgroundMusic->file_path);
        if (file_exists($path)) {
            unlink($path);
        }

        $backgroundMusic->delete();

        return back()->with('success', 'Music deleted successfully.');
    }
}
