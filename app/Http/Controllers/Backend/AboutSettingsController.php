<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AboutSettings;
use App\Models\AboutSections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class AboutSettingsController extends Controller
{
    public function index()
    {
        try {
            // Get or create about settings (singleton pattern)
            $aboutSettings = AboutSettings::first();
            if (!$aboutSettings) {
                $aboutSettings = new AboutSettings();
                $aboutSettings->page_title = 'Never Ending Trails';
                $aboutSettings->subtitle = 'Sharing stories of adventure, exploration, and the profound connections we make with nature and cultures around the world';
                $aboutSettings->save();
            }
            
            $sections = AboutSections::orderBy('position')->orderBy('created_at')->get();
            
            return view('backend.about-settings.index', compact('aboutSettings', 'sections'));
        } catch (Exception $e) {
            Log::error("Error fetching about settings: " . $e->getMessage());
            return back()->with('error', 'Failed to load about settings.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'vimeo_video_id' => 'nullable|string|max:255',
            'page_title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $aboutSettings = AboutSettings::first();
            if (!$aboutSettings) {
                $aboutSettings = new AboutSettings();
            }

            $aboutSettings->vimeo_video_id = $request->vimeo_video_id;
            $aboutSettings->page_title = $request->page_title;
            $aboutSettings->subtitle = $request->subtitle;
            $aboutSettings->description = $request->description;
            $aboutSettings->save();

            DB::commit();

            return redirect()
                ->route('admin.about-settings.index')
                ->with('success', 'About settings updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("About settings update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update about settings.')
                ->withInput();
        }
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'position' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $section = new AboutSections();
            $section->title = $request->title;
            $section->description = $request->description;
            $section->image = $request->image;
            $section->position = $request->position ?? 0;
            $section->save();

            DB::commit();

            return redirect()
                ->route('admin.about-settings.index')
                ->with('success', 'Section added successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Section store failed: " . $e->getMessage());
            return back()->with('error', 'Failed to add section.')
                ->withInput();
        }
    }

    public function updateSection(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'position' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $section = AboutSections::findOrFail($id);
            $section->title = $request->title;
            $section->description = $request->description;
            $section->image = $request->image;
            $section->position = $request->position ?? 0;
            $section->save();

            DB::commit();

            return redirect()
                ->route('admin.about-settings.index')
                ->with('success', 'Section updated successfully');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('admin.about-settings.index')
                ->with('error', 'Section not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Section update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update section.')
                ->withInput();
        }
    }

    public function destroySection($id)
    {
        DB::beginTransaction();
        try {
            $section = AboutSections::findOrFail($id);
            $section->delete();

            DB::commit();
            return redirect()
                ->route('admin.about-settings.index')
                ->with('success', 'Section deleted successfully');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('admin.about-settings.index')
                ->with('error', 'Section not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Section delete failed: " . $e->getMessage());
            return redirect()->route('admin.about-settings.index')
                ->with('error', 'Failed to delete section.');
        }
    }
}

