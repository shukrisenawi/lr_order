<?php

namespace App\Http\Controllers;

use App\Models\Gambar;
use App\Models\Bisnes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageController extends Controller
{
    /**
     * Serve business image for web interface (no API token required)
     */
    public function businessImage($filename): Response|StreamedResponse
    {
        try {
            $path = 'bisnes/' . $filename;
            
            if (!Storage::disk('public')->exists($path)) {
                // Return 1x1 transparent pixel if image not found
                return $this->transparentPixel();
            }
            
            $file = Storage::disk('public')->get($path);
            $mimeType = Storage::disk('public')->mimeType($path);
            
            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Cache-Control', 'public, max-age=3600');
                
        } catch (\Exception $e) {
            return $this->transparentPixel();
        }
    }

    /**
     * Serve gallery image for web interface (no API token required)
     */
    public function galleryImage($filename): Response|StreamedResponse
    {
        try {
            // Find the image record in database
            $gambar = Gambar::where('path', 'LIKE', '%' . $filename)->first();
            
            if (!$gambar || !Storage::disk('public')->exists($gambar->path)) {
                return $this->transparentPixel();
            }
            
            $file = Storage::disk('public')->get($gambar->path);
            $mimeType = Storage::disk('public')->mimeType($gambar->path);
            
            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Cache-Control', 'public, max-age=3600');
                
        } catch (\Exception $e) {
            return $this->transparentPixel();
        }
    }

    /**
     * Serve any image from storage for web interface
     */
    public function serveImage($path): Response|StreamedResponse
    {
        try {
            // Decode the path
            $decodedPath = base64_decode($path);
            
            if (!Storage::disk('public')->exists($decodedPath)) {
                return $this->transparentPixel();
            }
            
            $file = Storage::disk('public')->get($decodedPath);
            $mimeType = Storage::disk('public')->mimeType($decodedPath);
            
            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Cache-Control', 'public, max-age=3600');
                
        } catch (\Exception $e) {
            return $this->transparentPixel();
        }
    }

    /**
     * Return a 1x1 transparent pixel as fallback
     */
    private function transparentPixel(): Response
    {
        // 1x1 transparent PNG
        $pixel = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');
        
        return response($pixel, 200)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}
