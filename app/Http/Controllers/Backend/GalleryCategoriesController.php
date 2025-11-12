<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\GalleryCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class GalleryCategoriesController extends Controller
{
    public function index()
    {
        try {
            $galleryCategories = GalleryCategories::orderBy('name')->get();
            return view('backend.gallery-categories.index', compact('galleryCategories'));
        } catch (Exception $e) {
            Log::error("Error fetching gallery categories: " . $e->getMessage());
            return back()->with('error', 'Failed to load gallery categories.');
        }
    }

    public function create()
    {
        return view('backend.gallery-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:gallery_categories,name',
            'status' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $galleryCategory = new GalleryCategories();
            $galleryCategory->name = $request->name;
            $galleryCategory->slug = Str::slug($request->name);
            $galleryCategory->status = $request->has('status') ? true : false;

            $galleryCategory->save();
            DB::commit();

            return redirect()
                ->route('admin.gallery-categories.index')
                ->with('success', 'Gallery category added successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gallery category store failed: " . $e->getMessage());
            return back()->with('error', 'Failed to add gallery category. Please try again.')
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $category = GalleryCategories::findOrFail($id);
            return view('backend.gallery-categories.create', compact('category'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.gallery-categories.index')
                ->with('error', 'Gallery category not found.');
        } catch (Exception $e) {
            Log::error("Edit failed: " . $e->getMessage());
            return redirect()->route('admin.gallery-categories.index')
                ->with('error', 'Something went wrong.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:gallery_categories,name,' . $id,
            'status' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $category = GalleryCategories::findOrFail($id);

            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->status = $request->has('status') ? true : false;
            $category->save();
            DB::commit();

            return redirect()
                ->route('admin.gallery-categories.index')
                ->with('success', 'Gallery category updated successfully');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('admin.gallery-categories.index')
                ->with('error', 'Gallery category not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update gallery category.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $category = GalleryCategories::findOrFail($id);
            $category->delete();

            DB::commit();
            return redirect()
                ->route('admin.gallery-categories.index')
                ->with('success', 'Gallery category deleted successfully');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('admin.gallery-categories.index')
                ->with('error', 'Gallery category not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Delete failed: " . $e->getMessage());
            return redirect()->route('admin.gallery-categories.index')
                ->with('error', 'Failed to delete gallery category.');
        }
    }
}

