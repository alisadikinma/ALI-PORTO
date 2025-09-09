<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\GalleryItem;
use App\Models\Award;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GaleriController extends Controller
{
    public function index()
    {
        $title = 'Data Galeri';
        $galeri = Galeri::with(['galleryItems' => function($query) {
            $query->orderBy('sequence', 'asc');
        }])
        ->orderBy('sequence', 'asc')
        ->orderByDesc('id_galeri')
        ->get();
        
        return view('galeri.index', compact('galeri', 'title'));
    }

    public function create()
    {
        $title = 'Tambah Galeri';
        $awards = Award::orderBy('nama_award', 'asc')->get();
        return view('galeri.create', compact('title', 'awards'));
    }

    public function store(Request $request)
    {
        // ENHANCED DEBUG: Log all request data with more detail
        Log::info('=== GALLERY STORE DEBUG START ===');
        Log::info('Request Method: ' . $request->method());
        Log::info('Request URL: ' . $request->url());
        Log::info('All Input Data:', $request->all());
        Log::info('Files Data:', $request->allFiles());
        Log::info('Has gallery_items: ' . ($request->has('gallery_items') ? 'YES' : 'NO'));
        
        // Debug each gallery item input
        if ($request->has('gallery_items')) {
            Log::info('Gallery Items Count: ' . count($request->gallery_items));
            foreach ($request->gallery_items as $index => $item) {
                Log::info("Gallery Item $index:", $item);
                $fileKey = "gallery_items.$index.file";
                Log::info("Has file at $fileKey: " . ($request->hasFile($fileKey) ? 'YES' : 'NO'));
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    Log::info("File details for $fileKey:", [
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'valid' => $file->isValid()
                    ]);
                }
            }
        }
        
        // Basic validation first
        try {
            $request->validate([
                'nama_galeri' => 'required|string|max:255',
                'company' => 'nullable|string|max:255',
                'period' => 'nullable|string|max:255',
                'deskripsi_galeri' => 'nullable|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
                'sequence' => 'nullable|integer|min:0',
                'status' => 'required|in:Active,Inactive',
                'id_award' => 'nullable|exists:award,id_award',
            ]);
            Log::info('Validation passed');
        } catch (\Exception $e) {
            Log::error('Validation failed: ' . $e->getMessage());
            throw $e;
        }

        DB::beginTransaction();

        try {
            // Create gallery first
            $galeriData = [
                'nama_galeri' => $request->nama_galeri,
                'company' => $request->company,
                'period' => $request->period,
                'deskripsi_galeri' => $request->deskripsi_galeri,
                'sequence' => $request->sequence ?? 0,
                'status' => $request->status ?? 'Active',
            ];

            Log::info('Gallery data prepared:', $galeriData);

            // Upload thumbnail
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $thumbnailName = 'thumb_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Ensure directory exists
                $uploadPath = public_path('file/galeri');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $file->move($uploadPath, $thumbnailName);
                $galeriData['thumbnail'] = $thumbnailName;
                Log::info('Thumbnail uploaded:', ['filename' => $thumbnailName]);
            }

            $galeri = Galeri::create($galeriData);
            Log::info('Gallery created successfully with ID: ' . $galeri->id_galeri);

            // Process gallery items with enhanced debugging
            if ($request->has('gallery_items') && is_array($request->gallery_items)) {
                Log::info('Processing ' . count($request->gallery_items) . ' gallery items');
                
                foreach ($request->gallery_items as $index => $item) {
                    Log::info("Processing item $index:", $item);
                    
                    // Skip empty items
                    if (empty($item['type'])) {
                        Log::info("Skipping empty item at index $index");
                        continue;
                    }

                    $itemData = [
                        'id_galeri' => $galeri->id_galeri,
                        'type' => $item['type'],
                        'id_award' => $request->id_award,
                        'sequence' => $item['sequence'] ?? $index,
                        'status' => 'Active',
                    ];

                    Log::info("Item data prepared for index $index:", $itemData);

                    // Handle file upload for image type
                    if ($item['type'] === 'image') {
                        // Check if new file is uploaded via the actual file upload mechanism
                        $fileKey = "gallery_items.$index.file";
                        Log::info("Checking for file upload at key: $fileKey");
                        
                        if ($request->hasFile($fileKey)) {
                            try {
                                $file = $request->file($fileKey);
                                Log::info("File info for index $index:", [
                                    'original_name' => $file->getClientOriginalName(),
                                    'size' => $file->getSize(),
                                    'mime_type' => $file->getMimeType(),
                                    'is_valid' => $file->isValid()
                                ]);
                                
                                if ($file->isValid()) {
                                    $filename = 'gallery_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                                    
                                    $uploadPath = public_path('file/galeri');
                                    if (!file_exists($uploadPath)) {
                                        mkdir($uploadPath, 0755, true);
                                    }
                                    
                                    $file->move($uploadPath, $filename);
                                    $itemData['file_name'] = $filename;
                                    Log::info("File uploaded successfully for index $index: $filename");
                                } else {
                                    Log::error("Invalid file for index $index");
                                    continue;
                                }
                            } catch (\Exception $e) {
                                Log::error("File upload failed for index $index: " . $e->getMessage());
                                throw new \Exception("Failed to upload file for item $index: " . $e->getMessage());
                            }
                        } else {
                            Log::warning("Image type item without valid file at index $index, item data:", $item);
                            continue;
                        }
                    }

                    // Handle YouTube URL
                    if ($item['type'] === 'youtube') {
                        if (isset($item['youtube_url']) && !empty($item['youtube_url'])) {
                            $itemData['youtube_url'] = $item['youtube_url'];
                            Log::info("YouTube URL set for index $index: " . $item['youtube_url']);
                        } else {
                            Log::warning("YouTube type item without URL at index $index, skipping");
                            continue;
                        }
                    }

                    // Create gallery item
                    Log::info("Creating gallery item for index $index with data:", $itemData);
                    $galleryItem = GalleryItem::create($itemData);
                    Log::info("Gallery item created successfully: ID {$galleryItem->id_gallery_item}");
                }
            } else {
                Log::info('No gallery items to process or gallery_items is not an array');
            }

            DB::commit();
            Log::info('=== GALLERY STORE SUCCESS ===');
            
            return redirect()->route('galeri.index')->with('Sukses', 'Berhasil Tambah Galeri');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('=== GALLERY STORE FAILED ===');
            Log::error('Error: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('Error', 'Gagal menambah galeri: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit(Galeri $galeri)
    {
        $title = 'Edit Galeri';
        $awards = Award::orderBy('nama_award', 'asc')->get();
        $galeri->load(['galleryItems' => function($query) {
            $query->orderBy('id_gallery_item', 'asc');
        }]);
        
        return view('galeri.edit', compact('title', 'galeri', 'awards'));
    }

    public function update(Request $request, Galeri $galeri)
    {
        // ENHANCED DEBUG: Log all request data with more detail
        Log::info('=== GALLERY UPDATE DEBUG START ===');
        Log::info('Gallery ID: ' . $galeri->id_galeri);
        Log::info('Request Method: ' . $request->method());
        Log::info('All Input Data:', $request->all());
        Log::info('Files Data:', $request->allFiles());
        Log::info('Has gallery_items: ' . ($request->has('gallery_items') ? 'YES' : 'NO'));
        
        // Debug each gallery item input
        if ($request->has('gallery_items')) {
            Log::info('Gallery Items Count: ' . count($request->gallery_items));
            foreach ($request->gallery_items as $index => $item) {
                Log::info("Gallery Item $index:", $item);
                $fileKey = "gallery_items.$index.file";
                Log::info("Has file at $fileKey: " . ($request->hasFile($fileKey) ? 'YES' : 'NO'));
                if ($request->hasFile($fileKey)) {
                    $file = $request->file($fileKey);
                    Log::info("File details for $fileKey:", [
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'valid' => $file->isValid()
                    ]);
                }
            }
        }
        
        // Basic validation first
        try {
            $request->validate([
                'nama_galeri' => 'required|string|max:255',
                'company' => 'nullable|string|max:255',
                'period' => 'nullable|string|max:255',
                'deskripsi_galeri' => 'nullable|string',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
                'sequence' => 'nullable|integer|min:0',
                'status' => 'required|in:Active,Inactive',
                'id_award' => 'nullable|exists:award,id_award',
            ]);
            Log::info('Validation passed');
        } catch (\Exception $e) {
            Log::error('Validation failed: ' . $e->getMessage());
            throw $e;
        }

        DB::beginTransaction();

        try {
            // Update gallery basic info
            $galeriData = [
                'nama_galeri' => $request->nama_galeri,
                'company' => $request->company,
                'period' => $request->period,
                'deskripsi_galeri' => $request->deskripsi_galeri,
                'sequence' => $request->sequence ?? 0,
                'status' => $request->status ?? 'Active',
            ];

            Log::info('Gallery update data prepared:', $galeriData);

            // Update thumbnail
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail
                if ($galeri->thumbnail && file_exists(public_path('file/galeri/' . $galeri->thumbnail))) {
                    unlink(public_path('file/galeri/' . $galeri->thumbnail));
                }

                $file = $request->file('thumbnail');
                $thumbnailName = 'thumb_' . time() . '.' . $file->getClientOriginalExtension();
                
                $uploadPath = public_path('file/galeri');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $file->move($uploadPath, $thumbnailName);
                $galeriData['thumbnail'] = $thumbnailName;
                Log::info('Thumbnail updated:', ['filename' => $thumbnailName]);
            }

            $galeri->update($galeriData);
            Log::info('Gallery basic data updated successfully');

            // SAFE UPDATE: Always update award association on existing gallery items
            $existingItemsCount = $galeri->galleryItems()->count();
            Log::info("Found $existingItemsCount existing gallery items");
            
            if ($existingItemsCount > 0) {
                $updatedCount = $galeri->galleryItems()->update([
                    'id_award' => $request->id_award
                ]);
                Log::info("Updated award association for $updatedCount gallery items to award ID: " . ($request->id_award ?? 'NULL'));
            }

            // Enhanced gallery items processing
            $submittedItems = $request->input('gallery_items', []);
            Log::info('Submitted items count: ' . count($submittedItems));
            
            if (!empty($submittedItems) && is_array($submittedItems)) {
                Log::info('Processing submitted gallery items');
                
                // Check if we have valid items
                $validItems = array_filter($submittedItems, function($item) {
                    return !empty($item['type']);
                });
                
                Log::info('Valid items count: ' . count($validItems));
                
                if (count($validItems) > 0) {
                    Log::info('Proceeding with gallery items update');
                    
                    // Delete existing gallery items and their files
                    $existingItems = $galeri->galleryItems;
                    Log::info('Deleting ' . $existingItems->count() . ' existing items');
                    
                    foreach ($existingItems as $item) {
                        if ($item->file_name && $item->type === 'image') {
                            $filePath = public_path('file/galeri/' . $item->file_name);
                            if (file_exists($filePath)) {
                                unlink($filePath);
                                Log::info('Deleted file: ' . $item->file_name);
                            }
                        }
                        $item->delete();
                    }

                    // Create new gallery items
                    foreach ($submittedItems as $index => $item) {
                        if (empty($item['type'])) {
                            Log::info("Skipping empty item at index $index");
                            continue;
                        }

                        $itemData = [
                            'id_galeri' => $galeri->id_galeri,
                            'type' => $item['type'],
                            'id_award' => $request->id_award,
                            'sequence' => $item['sequence'] ?? $index,
                            'status' => 'Active',
                        ];

                        Log::info("Processing new item at index $index:", $itemData);

                        // Handle file upload for image
                        if ($item['type'] === 'image') {
                            // Check if new file is uploaded via the actual file upload mechanism
                            $fileKey = "gallery_items.$index.file";
                            Log::info("Checking for file upload at key: $fileKey");
                            
                            if ($request->hasFile($fileKey)) {
                                // Upload new file
                                $file = $request->file($fileKey);
                                if ($file->isValid()) {
                                    $filename = 'gallery_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                                    
                                    $uploadPath = public_path('file/galeri');
                                    if (!file_exists($uploadPath)) {
                                        mkdir($uploadPath, 0755, true);
                                    }
                                    
                                    $file->move($uploadPath, $filename);
                                    $itemData['file_name'] = $filename;
                                    Log::info("New file uploaded for index $index: $filename");
                                } else {
                                    Log::error("Invalid file for index $index");
                                    continue;
                                }
                            } elseif (isset($item['existing_file']) && !empty($item['existing_file'])) {
                                // Use existing file
                                $itemData['file_name'] = $item['existing_file'];
                                Log::info("Using existing file for index $index: " . $item['existing_file']);
                            } else {
                                Log::warning("Image type item without valid file at index $index, item data:", $item);
                                continue;
                            }
                        }

                        // Handle YouTube URL
                        if ($item['type'] === 'youtube') {
                            if (isset($item['youtube_url']) && !empty($item['youtube_url'])) {
                                $itemData['youtube_url'] = $item['youtube_url'];
                                Log::info("YouTube URL set for index $index: " . $item['youtube_url']);
                            } else {
                                Log::warning("YouTube type item without URL at index $index, skipping");
                                continue;
                            }
                        }

                        Log::info("Creating new gallery item for index $index with data:", $itemData);
                        $newItem = GalleryItem::create($itemData);
                        Log::info("New gallery item created: ID {$newItem->id_gallery_item}");
                    }
                } else {
                    Log::info('No valid gallery items to process');
                }
            } else {
                Log::info('No gallery items submitted, keeping existing items');
            }

            DB::commit();
            Log::info('=== GALLERY UPDATE SUCCESS ===');
            
            return redirect()->route('galeri.index')->with('Sukses', 'Berhasil Edit Galeri');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('=== GALLERY UPDATE FAILED ===');
            Log::error('Error: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->with('Error', 'Gagal mengupdate galeri: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Galeri $galeri)
    {
        Log::info('=== GALLERY DELETE DEBUG START ===');
        Log::info('Gallery ID: ' . $galeri->id_galeri);
        Log::info('Gallery Name: ' . $galeri->nama_galeri);

        DB::beginTransaction();

        try {
            // Delete thumbnail
            if ($galeri->thumbnail && file_exists(public_path('file/galeri/' . $galeri->thumbnail))) {
                unlink(public_path('file/galeri/' . $galeri->thumbnail));
                Log::info('Deleted thumbnail: ' . $galeri->thumbnail);
            }

            // Delete gallery items and their files
            $deletedItemsCount = 0;
            foreach ($galeri->galleryItems as $item) {
                if ($item->file_name && $item->type === 'image') {
                    $filePath = public_path('file/galeri/' . $item->file_name);
                    if (file_exists($filePath)) {
                        unlink($filePath);
                        Log::info('Deleted file: ' . $item->file_name);
                    }
                }
                $item->delete();
                $deletedItemsCount++;
            }
            
            Log::info('Deleted ' . $deletedItemsCount . ' gallery items');

            $galeri->delete();
            Log::info('Gallery deleted successfully');

            DB::commit();
            Log::info('=== GALLERY DELETE SUCCESS ===');
            
            return redirect()->route('galeri.index')->with('Sukses', 'Berhasil Hapus Galeri');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('=== GALLERY DELETE FAILED ===');
            Log::error('Error: ' . $e->getMessage());
            Log::error('Trace: ' . $e->getTraceAsString());
            
            return redirect()->route('galeri.index')->with('Error', 'Gagal menghapus galeri: ' . $e->getMessage());
        }
    }

    public function storeImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }

    // API endpoint for getting gallery items by galeri ID
    public function getGalleryItems($galeriId)
    {
        try {
            $galeri = Galeri::with(['galleryItems' => function($query) {
                $query->where('status', 'Active')
                      ->orderBy('sequence')
                      ->orderBy('id_gallery_item');
            }])
            ->where('id_galeri', $galeriId)
            ->where('status', 'Active')
            ->first();

            if (!$galeri) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gallery not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'galeri' => [
                    'id' => $galeri->id_galeri,
                    'nama_galeri' => $galeri->nama_galeri,
                    'company' => $galeri->company,
                    'period' => $galeri->period,
                    'deskripsi_galeri' => $galeri->deskripsi_galeri,
                ],
                'items' => $galeri->galleryItems->map(function($item) {
                    return [
                        'id' => $item->id_gallery_item,
                        'type' => $item->type,
                        'title' => $item->galeri->nama_galeri ?? 'Gallery Item',
                        'description' => null,
                        'sequence' => $item->sequence,
                        'status' => $item->status,
                        'file_url' => $item->type === 'image' && $item->file_name ? asset('file/galeri/' . $item->file_name) : null,
                        'youtube_url' => $item->type === 'youtube' ? $item->youtube_url : null,
                        'youtube_embed' => $item->type === 'youtube' && $item->youtube_url ? $this->convertYoutubeToEmbed($item->youtube_url) : null,
                        'thumbnail_url' => $item->type === 'youtube' && $item->youtube_url ? 'https://img.youtube.com/vi/' . $this->extractYouTubeId($item->youtube_url) . '/mqdefault.jpg' : null,
                        'award' => $item->id_award ? ['nama_award' => 'Award #' . $item->id_award] : null
                    ];
                })
            ]);

        } catch (\Exception $e) {
            Log::error('Error fetching gallery items:', [
                'galeri_id' => $galeriId,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Extract YouTube video ID from URL
     */
    private function extractYouTubeId($url)
    {
        $regex = '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/';
        $match = preg_match($regex, $url, $matches);
        return $match ? $matches[1] : null;
    }

    // API endpoint for getting gallery items by award
    public function getGalleryByAward($awardId)
    {
        $galleryItems = GalleryItem::with(['galeri'])
            ->where('id_award', $awardId)
            ->orderBy('id_gallery_item', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $galleryItems->map(function($item) {
                return [
                    'id' => $item->id_gallery_item,
                    'type' => $item->type,
                    'file_url' => $item->type === 'image' && $item->file_name ? asset('file/galeri/' . $item->file_name) : null,
                    'thumbnail_url' => $item->type === 'youtube' && $item->youtube_url ? 'https://img.youtube.com/vi/' . $this->extractYouTubeId($item->youtube_url) . '/mqdefault.jpg' : null,
                    'gallery_name' => $item->galeri->nama_galeri,
                ];
            })
        ]);
    }

    /**
     * Show a specific gallery item for modal (AJAX)
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showItem($id)
    {
        try {
            $item = GalleryItem::with('galeri')
                ->where('id_gallery_item', $id)
                ->where('status', 'Active')
                ->first();

            if (!$item) {
                return response()->json([
                    'error' => 'Item not found or inactive'
                ], 404);
            }

            $response = [
                'id' => $item->id_gallery_item,
                'type' => $item->type,
                'title' => $item->galeri->nama_galeri ?? 'Gallery Item',
                'galeri' => [
                    'id_galeri' => $item->galeri->id_galeri,
                    'nama_galeri' => $item->galeri->nama_galeri,
                    'company' => $item->galeri->company ?? '—',
                    'period' => $item->galeri->period ?? '—',
                    'deskripsi_galeri' => $item->galeri->deskripsi_galeri ?? ''
                ],
                'image_url' => null,
                'video_url' => null,
                'youtube_embed' => null
            ];

            // Set media URLs based on type
            if ($item->type === 'image' && $item->file_name) {
                $response['image_url'] = asset('file/galeri/' . $item->file_name);
            } elseif ($item->type === 'video' && $item->file_name) {
                $response['video_url'] = asset('file/galeri/' . $item->file_name);
            } elseif ($item->type === 'youtube' && $item->youtube_url) {
                $response['youtube_embed'] = $this->convertYoutubeToEmbed($item->youtube_url);
            }

            return response()->json($response);

        } catch (\Exception $e) {
            Log::error('Error fetching gallery item:', [
                'item_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'error' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Show a specific gallery with its items
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $galeri = Galeri::with(['items' => function($query) {
            $query->where('status', 'Active')
                  ->orderBy('sequence')
                  ->orderBy('id_gallery_item');
        }])
        ->where('id_galeri', $id)
        ->where('status', 'Active')
        ->firstOrFail();

        $title = $galeri->nama_galeri;

        return view('galeri.show', compact('galeri', 'title'));
    }

    /**
     * Convert YouTube URL to embed format
     *
     * @param string $url
     * @return string
     */
    private function convertYoutubeToEmbed($url)
    {
        // Handle various YouTube URL formats
        $videoId = null;
        
        // Check for youtube.com/watch?v= format
        if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Check for youtu.be/ format
        elseif (preg_match('/youtu\.be\/([^?]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Check for youtube.com/embed/ format (already embed)
        elseif (preg_match('/youtube\.com\/embed\/([^?]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        
        if ($videoId) {
            return 'https://www.youtube.com/embed/' . $videoId;
        }
        
        return $url;
    }
}
