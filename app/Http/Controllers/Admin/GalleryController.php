<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGalleryImageRequest;
use App\Models\GalleryImage;
use App\Services\ImageProcessingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    protected ImageProcessingService $imageService;

    public function __construct(ImageProcessingService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of gallery images
     */
    public function index(Request $request)
    {
        $query = GalleryImage::query()->orderBy('display_order')->orderBy('created_at', 'desc');

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $images = $query->paginate(12);

        // Get all categories for filter dropdown
        $categories = GalleryImage::distinct()->pluck('category')->sort();

        return view('admin.gallery.index', compact('images', 'categories'));
    }

    /**
     * Show the form for uploading new images
     */
    public function create()
    {
        $categories = [
            'Events',
            'Sports',
            'Academics',
            'Infrastructure',
            'Celebrations',
            'Cultural',
            'Awards',
            'Other',
        ];

        return view('admin.gallery.create', compact('categories'));
    }

    /**
     * Store newly uploaded images
     */
    public function store(StoreGalleryImageRequest $request)
    {
        $schoolId = session('active_school_id');
        $school = \App\Models\School::find($schoolId);
        $uploadedCount = 0;

        DB::transaction(function () use ($request, $school, &$uploadedCount) {
            // Get the highest display order
            $maxOrder = GalleryImage::max('display_order') ?? 0;

            foreach ($request->file('images') as $file) {
                $maxOrder++;

                // Process image (resize + thumbnail)
                $paths = $this->imageService->processImage(
                    $file,
                    "gallery/{$school->code}",
                    1200,
                    400
                );

                GalleryImage::create([
                    'category' => $request->category,
                    'title' => $request->title ?? 'Gallery Image',
                    'image_path' => $paths['path'],
                    'thumbnail_path' => $paths['thumbnail'],
                    'display_order' => $maxOrder,
                ]);

                $uploadedCount++;
            }
        });

        return redirect()->route('admin.gallery.index')
            ->with('success', "Successfully uploaded {$uploadedCount} " . str('image')->plural($uploadedCount) . '.');
    }

    /**
     * Show the form for editing an image
     */
    public function edit(GalleryImage $gallery)
    {
        $categories = [
            'Events',
            'Sports',
            'Academics',
            'Infrastructure',
            'Celebrations',
            'Cultural',
            'Awards',
            'Other',
        ];

        return view('admin.gallery.edit', compact('gallery', 'categories'));
    }

    /**
     * Update the specified image metadata
     */
    public function update(Request $request, GalleryImage $gallery)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery image updated successfully.');
    }

    /**
     * Remove the specified image from storage
     */
    public function destroy(GalleryImage $gallery)
    {
        // Delete image files from storage
        $this->imageService->deleteImage($gallery->image_path, $gallery->thumbnail_path);

        // Delete database record
        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery image deleted successfully.');
    }

    /**
     * Update display order via AJAX (for drag-drop reordering)
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->orders as $id => $order) {
                GalleryImage::where('id', $id)->update(['display_order' => $order]);
            }
        });

        return response()->json(['success' => true]);
    }
}
