<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\StoryCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class StoryCategoriesController extends Controller
{
    public function index()
    {
        try {
            $storyCategories = StoryCategories::orderBy('position')->orderBy('name')->get();
            return view('backend.story-categories.index', compact('storyCategories'));
        } catch (Exception $e) {
            Log::error("Error fetching story categories: " . $e->getMessage());
            return back()->with('error', 'Failed to load story categories.');
        }
    }

    public function create()
    {
        return view('backend.story-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:story_categories,name',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|string|max:2048',
            'position' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $storyCategory = new StoryCategories();
            $storyCategory->name = $request->name;
            $storyCategory->slug = Str::slug($request->name);
            $storyCategory->description = $request->description;
            $storyCategory->thumbnail = $request->thumbnail;
            $storyCategory->position = $request->position ?? 0;
            $storyCategory->status = $request->has('status') ? true : false;

            $storyCategory->save();
            DB::commit();

            return redirect()
                ->route('admin.story-categories.index')
                ->with('success', 'Story category added successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Story category store failed: " . $e->getMessage());
            return back()->with('error', 'Failed to add story category. Please try again.')
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $category = StoryCategories::findOrFail($id);
            return view('backend.story-categories.create', compact('category'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.story-categories.index')
                ->with('error', 'Story category not found.');
        } catch (Exception $e) {
            Log::error("Edit failed: " . $e->getMessage());
            return redirect()->route('admin.story-categories.index')
                ->with('error', 'Something went wrong.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:story_categories,name,' . $id,
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|string|max:2048',
            'position' => 'nullable|integer',
            'status' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $category = StoryCategories::findOrFail($id);

            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->description = $request->description;
            $category->thumbnail = $request->thumbnail;
            $category->position = $request->position ?? 0;
            $category->status = $request->has('status') ? true : false;
            $category->save();
            DB::commit();

            return redirect()
                ->route('admin.story-categories.index')
                ->with('success', 'Story category updated successfully');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('admin.story-categories.index')
                ->with('error', 'Story category not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update story category.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $category = StoryCategories::findOrFail($id);
            $category->delete();

            DB::commit();
            return redirect()
                ->route('admin.story-categories.index')
                ->with('success', 'Story category deleted successfully');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('admin.story-categories.index')
                ->with('error', 'Story category not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Delete failed: " . $e->getMessage());
            return redirect()->route('admin.story-categories.index')
                ->with('error', 'Failed to delete story category.');
        }
    }
}

