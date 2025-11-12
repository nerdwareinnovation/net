<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\StoryCategories;
use App\Models\Stories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class StoriesController extends Controller
{
    public function index()
    {
        try {
            $stories = Stories::with(['category', 'user'])->latest()->get();
            return view('backend.stories.index', compact('stories'));
        } catch (Exception $e) {
            Log::error("Error fetching stories: " . $e->getMessage());
            return back()->with('error', 'Failed to load stories.');
        }
    }

    public function create()
    {
        $storyCategories = StoryCategories::where('status', true)->orderBy('position')->orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('backend.stories.create', compact('storyCategories', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'     => 'required|exists:story_categories,id',
            'user_id'         => 'required|exists:users,id',
            'thumbnail'       => 'nullable|string|max:2048',
            'description'     => 'nullable|string',
            'is_featured'     => 'nullable|boolean',
            'position'        => 'nullable|integer',
            'status'          => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $story = new Stories();
            $story->title = $request->title;
            $story->slug = Str::slug($request->title);
            $story->category_id = $request->category_id;
            $story->user_id = $request->user_id;
            $story->thumbnail = $request->thumbnail;
            $story->description = $request->description;
            $story->is_featured = $request->has('is_featured') ? true : false;
            $story->position = $request->position ?? 0;
            $story->status = $request->status ?? 'active';

            if($request->story_images != ''){
                $images = explode(',', $request->input('story_images'));
                $story->story_images = $images;
            }

            $story->save();
            DB::commit();

            return redirect()
                ->route('admin.stories.index')
                ->with('success', 'Story created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Story store failed: " . $e->getMessage());
            return back()->with('error', 'Failed to create story.')->withInput();
        }
    }

    public function show(Stories $story)
    {
        return view('backend.stories.show', compact('story'));
    }

    public function edit(Stories $story)
    {
        $storyCategories = StoryCategories::where('status', true)->orderBy('position')->orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('backend.stories.create', compact('story', 'storyCategories', 'users'));
    }

    public function update(Request $request, Stories $story)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'     => 'required|exists:story_categories,id',
            'user_id'         => 'required|exists:users,id',
            'thumbnail'       => 'nullable|string|max:2048',
            'description'     => 'nullable|string',
            'is_featured'     => 'nullable|boolean',
            'position'        => 'nullable|integer',
            'status'          => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $story->title = $request->title;
            $story->slug = Str::slug($request->title);
            $story->category_id = $request->category_id;
            $story->user_id = $request->user_id;
            $story->thumbnail = $request->thumbnail;
            $story->description = $request->description;
            $story->is_featured = $request->has('is_featured') ? true : false;
            $story->position = $request->position ?? 0;
            $story->status = $request->status ?? 'active';

            if($request->story_images != ''){
                $images = explode(',', $request->input('story_images'));
                $story->story_images = $images;
            }

            $story->save();
            DB::commit();

            return redirect()
                ->route('admin.stories.index')
                ->with('success', 'Story updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Story update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update story.')->withInput();
        }
    }

    public function destroy(Stories $story)
    {
        DB::beginTransaction();
        try {
            if ($story->thumbnail && Storage::disk('public')->exists($story->thumbnail)) {
                Storage::disk('public')->delete($story->thumbnail);
            }

            if ($story->story_images && is_array($story->story_images)) {
                foreach ($story->story_images as $image) {
                    if ($image && Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }

            $story->delete();
            DB::commit();

            return redirect()
                ->route('admin.stories.index')
                ->with('success', 'Story deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Story delete failed: " . $e->getMessage());
            return redirect()->route('admin.stories.index')
                ->with('error', 'Failed to delete story.');
        }
    }
}

