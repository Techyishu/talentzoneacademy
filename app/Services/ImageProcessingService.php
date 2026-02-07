<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageProcessingService
{
    /**
     * Process and save an uploaded image with thumbnail generation
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory Directory within uploads/ (e.g., 'gallery/SCH001')
     * @param int $maxWidth Maximum width for web-optimized version
     * @param int $thumbnailSize Size for square thumbnail
     * @return array ['path' => 'full_path', 'thumbnail' => 'thumbnail_path']
     */
    public function processImage($file, string $directory, int $maxWidth = 1200, int $thumbnailSize = 400): array
    {
        // Generate unique filename
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $thumbnailFilename = 'thumb_' . $filename;

        // Create directory if not exists
        $fullPath = "uploads/{$directory}";
        Storage::makeDirectory("public/{$fullPath}");

        // Load original image
        $image = Image::read($file);

        // Resize main image (maintain aspect ratio, max width)
        if ($image->width() > $maxWidth) {
            $image->scale(width: $maxWidth);
        }

        // Save main image
        $image->save(storage_path("app/public/{$fullPath}/{$filename}"), quality: 85);

        // Create thumbnail (square crop)
        $thumbnail = Image::read($file);
        $thumbnail->cover($thumbnailSize, $thumbnailSize);
        $thumbnail->save(storage_path("app/public/{$fullPath}/{$thumbnailFilename}"), quality: 80);

        return [
            'path' => "{$fullPath}/{$filename}",
            'thumbnail' => "{$fullPath}/{$thumbnailFilename}",
        ];
    }

    /**
     * Delete image and its thumbnail from storage
     *
     * @param string $imagePath Path to main image
     * @param string|null $thumbnailPath Path to thumbnail
     * @return void
     */
    public function deleteImage(string $imagePath, ?string $thumbnailPath = null): void
    {
        // Delete main image
        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        // Delete thumbnail
        if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
            Storage::disk('public')->delete($thumbnailPath);
        }
    }

    /**
     * Get the thumbnail path from a main image path
     *
     * @param string $imagePath
     * @return string
     */
    public function getThumbnailPath(string $imagePath): string
    {
        $pathInfo = pathinfo($imagePath);
        return $pathInfo['dirname'] . '/thumb_' . $pathInfo['basename'];
    }
}
