<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategories;
use App\Models\Galleries;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class GalleriesController extends Controller
{
    public function index()
    {
        try {
            $galleries = Galleries::with(['category'])->latest()->get();
            return view('backend.galleries.index', compact('galleries'));
        } catch (Exception $e) {
            Log::error("Error fetching galleries: " . $e->getMessage());
            return back()->with('error', 'Failed to load galleries.');
        }
    }

    public function create()
    {
        $galleryCategories = GalleryCategories::where('status', true)->orderBy('name')->get();
        return view('backend.galleries.create', compact('galleryCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'     => 'required|exists:gallery_categories,id',
            'thumbnail'       => 'nullable|string|max:2048',
            'description'     => 'nullable|string',
            'position'        => 'nullable|integer',
            'status'          => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $gallery = new Galleries();
            $gallery->title = $request->title;
            $gallery->slug = Str::slug($request->title);
            $gallery->category_id = $request->category_id;
            $gallery->thumbnail = $request->thumbnail;
            $gallery->description = $request->description;
            $gallery->position = $request->position ?? 0;
            $gallery->status = $request->status ?? 'active';

            $gallery->child_images = $this->prepareChildImages($request->input('child_images'));

            $gallery->save();
            DB::commit();

            return redirect()
                ->route('admin.galleries.index')
                ->with('success', 'Gallery created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gallery store failed: " . $e->getMessage());
            return back()->with('error', 'Failed to create gallery.')->withInput();
        }
    }

    public function show(Galleries $gallery)
    {
        return view('backend.galleries.show', compact('gallery'));
    }

    public function edit(Galleries $gallery)
    {
        $galleryCategories = GalleryCategories::where('status', true)->orderBy('name')->get();
        return view('backend.galleries.create', compact('gallery', 'galleryCategories'));
    }

    public function update(Request $request, Galleries $gallery)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'     => 'required|exists:gallery_categories,id',
            'thumbnail'       => 'nullable|string|max:2048',
            'description'     => 'nullable|string',
            'position'        => 'nullable|integer',
            'status'          => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $gallery->title = $request->title;
            $gallery->slug = Str::slug($request->title);
            $gallery->category_id = $request->category_id;
            $gallery->thumbnail = $request->thumbnail;
            $gallery->description = $request->description;
            $gallery->position = $request->position ?? 0;
            $gallery->status = $request->status ?? 'active';

            $gallery->child_images = $this->prepareChildImages($request->input('child_images'));

            $gallery->save();
            DB::commit();

            return redirect()
                ->route('admin.galleries.index')
                ->with('success', 'Gallery updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gallery update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update gallery.')->withInput();
        }
    }

    public function destroy(Galleries $gallery)
    {
        DB::beginTransaction();
        try {
            if ($gallery->thumbnail && Storage::disk('public')->exists($gallery->thumbnail)) {
                Storage::disk('public')->delete($gallery->thumbnail);
            }

            if ($gallery->child_images && is_array($gallery->child_images)) {
                foreach ($gallery->child_images as $image) {
                    $imagePath = is_array($image) ? ($image['url'] ?? null) : $image;
                    if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                        Storage::disk('public')->delete($imagePath);
                    }
                }
            }

            $gallery->delete();
            DB::commit();

            return redirect()
                ->route('admin.galleries.index')
                ->with('success', 'Gallery deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gallery delete failed: " . $e->getMessage());
            return redirect()->route('admin.galleries.index')
                ->with('error', 'Failed to delete gallery.');
        }
    }
    private function prepareChildImages(?string $childImagesInput): ?array
    {
        if (!$childImagesInput) {
            return null;
        }

        $decoded = json_decode($childImagesInput, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            return null;
        }

        $normalized = [];

        foreach ($decoded as $image) {
            if (is_string($image) && $image !== '') {
                $normalized[] = [
                    'url' => $image,
                    'title' => '',
                    'short_description' => '',
                    'date' => '',
                ];
                continue;
            }

            if (is_array($image) && !empty($image['url'])) {
                $normalized[] = [
                    'url' => $image['url'],
                    'title' => $image['title'] ?? '',
                    'short_description' => $image['short_description'] ?? '',
                    'date' => $image['date'] ?? '',
                ];
            }
        }

        return count($normalized) ? $normalized : null;
    }
}

