<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Generate secure URL for business image
     */
    public static function businessImageUrl($filename)
    {
        if (!$filename) {
            return self::placeholderImageUrl(300, 200, 'No Business Image');
        }

        return route('web.image.business', ['filename' => $filename]);
    }

    /**
     * Generate secure URL for gallery image
     */
    public static function galleryImageUrl($filename)
    {
        if (!$filename) {
            return self::placeholderImageUrl(300, 200, 'No Image');
        }

        return route('web.image.gallery', ['filename' => basename($filename)]);
    }

    /**
     * Generate secure URL for any image path
     */
    public static function secureImageUrl($path)
    {
        if (!$path) {
            return self::placeholderImageUrl(300, 200, 'No Image');
        }

        return route('web.image.serve', ['path' => base64_encode($path)]);
    }

    /**
     * Check if image exists in storage
     */
    public static function imageExists($path)
    {
        if (!$path) {
            return false;
        }

        return Storage::disk('public')->exists($path);
    }

    /**
     * Get image MIME type
     */
    public static function getImageMimeType($path)
    {
        if (!$path || !self::imageExists($path)) {
            return null;
        }

        return Storage::disk('public')->mimeType($path);
    }

    /**
     * Get image size
     */
    public static function getImageSize($path)
    {
        if (!$path || !self::imageExists($path)) {
            return null;
        }

        return Storage::disk('public')->size($path);
    }

    /**
     * Generate placeholder image URL
     */
    public static function placeholderImageUrl($width = 300, $height = 200, $text = 'No Image')
    {
        return "https://via.placeholder.com/{$width}x{$height}/f3f4f6/9ca3af?text=" . urlencode($text);
    }

    /**
     * Get secure image URL with fallback to placeholder
     */
    public static function getImageUrlWithFallback($path, $type = 'general')
    {
        if (!$path) {
            return self::placeholderImageUrl();
        }

        switch ($type) {
            case 'business':
                return self::businessImageUrl($path);
            case 'gallery':
                return self::galleryImageUrl($path);
            default:
                return self::secureImageUrl($path);
        }
    }

    /**
     * Generate API URL for business image (requires token)
     */
    public static function apiBusinessImageUrl($filename)
    {
        if (!$filename) {
            return null;
        }

        return route('api.image.business', ['filename' => $filename]);
    }

    /**
     * Generate API URL for gallery image (requires token)
     */
    public static function apiGalleryImageUrl($filename)
    {
        if (!$filename) {
            return null;
        }

        return route('api.image.gallery', ['filename' => basename($filename)]);
    }

    /**
     * Generate API URL for any image path (requires token)
     */
    public static function apiSecureImageUrl($path)
    {
        if (!$path) {
            return null;
        }

        return route('api.image.serve', ['path' => base64_encode($path)]);
    }
}
