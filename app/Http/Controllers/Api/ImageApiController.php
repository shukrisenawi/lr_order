<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gambar;
use App\Models\Bisnes;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageApiController extends Controller
{
    /**
     * Serve business image with authentication
     */
    public function businessImage($filename): Response|StreamedResponse
    {
        try {
            $path = 'bisnes/' . $filename;
            
            if (!Storage::disk('public')->exists($path)) {
                return response('Image not found', 404);
            }
            
            $file = Storage::disk('public')->get($path);
            $mimeType = Storage::disk('public')->mimeType($path);
            
            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Cache-Control', 'public, max-age=3600')
                ->header('X-Served-By', 'API');
                
        } catch (\Exception $e) {
            return response('Error serving image', 500);
        }
    }

    /**
     * Serve gallery image with authentication
     */
    public function galleryImage($filename): Response|StreamedResponse
    {
        try {
            // Find the image record in database
            $gambar = Gambar::where('path', 'LIKE', '%' . $filename)->first();
            
            if (!$gambar) {
                return response('Image not found', 404);
            }
            
            if (!Storage::disk('public')->exists($gambar->path)) {
                return response('Image file not found', 404);
            }
            
            $file = Storage::disk('public')->get($gambar->path);
            $mimeType = Storage::disk('public')->mimeType($gambar->path);
            
            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Cache-Control', 'public, max-age=3600')
                ->header('X-Served-By', 'API');
                
        } catch (\Exception $e) {
            return response('Error serving image', 500);
        }
    }

    /**
     * Serve any image from storage with authentication
     */
    public function serveImage($path): Response|StreamedResponse
    {
        try {
            // Decode the path
            $decodedPath = base64_decode($path);
            
            if (!Storage::disk('public')->exists($decodedPath)) {
                return response('Image not found', 404);
            }
            
            $file = Storage::disk('public')->get($decodedPath);
            $mimeType = Storage::disk('public')->mimeType($decodedPath);
            
            return response($file, 200)
                ->header('Content-Type', $mimeType)
                ->header('Cache-Control', 'public, max-age=3600')
                ->header('X-Served-By', 'API');
                
        } catch (\Exception $e) {
            return response('Error serving image', 500);
        }
    }

    /**
     * Get image info with authentication
     */
    public function imageInfo($id)
    {
        try {
            $gambar = Gambar::find($id);
            
            if (!$gambar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $gambar->id,
                    'nama' => $gambar->nama,
                    'path' => $gambar->path,
                    'size' => Storage::disk('public')->size($gambar->path),
                    'mime_type' => Storage::disk('public')->mimeType($gambar->path),
                    'url' => route('api.image.serve', ['path' => base64_encode($gambar->path)]),
                    'created_at' => $gambar->created_at
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving image info',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List all images with authentication
     */
    public function index()
    {
        try {
            $images = Gambar::select('id', 'nama', 'path', 'created_at')
                           ->orderBy('created_at', 'desc')
                           ->paginate(20);
            
            // Add secure URLs to each image
            $images->getCollection()->transform(function ($image) {
                $image->secure_url = route('api.image.serve', ['path' => base64_encode($image->path)]);
                return $image;
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Images retrieved successfully',
                'data' => $images
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving images',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload image with authentication
     */
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'nama' => 'required|string|max:255'
            ]);

            $file = $request->file('image');
            $path = $file->store('uploads', 'public');

            $gambar = Gambar::create([
                'nama' => $request->nama,
                'path' => $path
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'data' => [
                    'id' => $gambar->id,
                    'nama' => $gambar->nama,
                    'path' => $gambar->path,
                    'secure_url' => route('api.image.serve', ['path' => base64_encode($gambar->path)]),
                    'created_at' => $gambar->created_at
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading image',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete image with authentication
     */
    public function delete($id)
    {
        try {
            $gambar = Gambar::find($id);
            
            if (!$gambar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Image not found'
                ], 404);
            }
            
            // Delete file from storage
            if (Storage::disk('public')->exists($gambar->path)) {
                Storage::disk('public')->delete($gambar->path);
            }
            
            // Delete record from database
            $gambar->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting image',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
