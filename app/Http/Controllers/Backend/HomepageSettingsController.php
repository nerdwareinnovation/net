<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\HomepageSettings;
use App\Models\HomepageSections;
use App\Models\Stories;
use App\Models\Films;
use App\Models\Galleries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class HomepageSettingsController extends Controller
{
    public function index()
    {
        try {
            // Get or create homepage settings (singleton pattern)
            $homepageSettings = HomepageSettings::first();
            if (!$homepageSettings) {
                $homepageSettings = new HomepageSettings();
                $homepageSettings->vimeo_title = 'Dive Into Our Films';
                $homepageSettings->vimeo_description = 'Experience the world through our lens';
                $homepageSettings->vimeo_button_text = 'Explore Films';
                $homepageSettings->save();
            }
            
            // Get sections
            $sliderSections = HomepageSections::where('section_name', 'slider_section')
                ->orderBy('position')
                ->orderBy('created_at')
                ->get();
            
            $contentSections = HomepageSections::where('section_name', 'content_section')
                ->orderBy('position')
                ->orderBy('created_at')
                ->get();
            
            // Get available items for selection
            $stories = Stories::where('status', 'active')->orderBy('title')->get();
            $films = Films::where('status', 'active')->orderBy('title')->get();
            $galleries = Galleries::where('status', 'active')->orderBy('title')->get();
            
            return view('backend.homepage-settings.index', compact(
                'homepageSettings',
                'sliderSections',
                'contentSections',
                'stories',
                'films',
                'galleries'
            ));
        } catch (Exception $e) {
            Log::error("Error fetching homepage settings: " . $e->getMessage());
            return back()->with('error', 'Failed to load homepage settings.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'vimeo_video_id' => 'nullable|string|max:255',
            'vimeo_title' => 'nullable|string|max:255',
            'vimeo_description' => 'nullable|string',
            'vimeo_button_text' => 'nullable|string|max:255',
            'vimeo_button_url' => 'nullable|url|max:500',
            'vimeo_film_ids' => 'nullable|array',
            'vimeo_film_ids.*' => 'nullable|integer|exists:films,id',
            'featured_story_banner_image' => 'nullable|string|max:2048',
            'featured_story_title' => 'nullable|string|max:255',
            'featured_story_description' => 'nullable|string',
            'featured_story_button_text' => 'nullable|string|max:255',
            'featured_story_button_url' => 'nullable|url|max:500',
        ]);

        DB::beginTransaction();
        try {
            $homepageSettings = HomepageSettings::first();
            if (!$homepageSettings) {
                $homepageSettings = new HomepageSettings();
            }

            $homepageSettings->vimeo_video_id = $request->vimeo_video_id;
            $homepageSettings->vimeo_title = $request->vimeo_title;
            $homepageSettings->vimeo_description = $request->vimeo_description;
            $homepageSettings->vimeo_button_text = $request->vimeo_button_text;
            $homepageSettings->vimeo_button_url = $request->vimeo_button_url;
            
            // Handle vimeo_film_ids (array from multiple select)
            if($request->has('vimeo_film_ids') && is_array($request->vimeo_film_ids) && count($request->vimeo_film_ids) > 0){
                $filmIds = array_filter(array_map('intval', $request->vimeo_film_ids));
                $homepageSettings->vimeo_film_ids = !empty($filmIds) ? array_values($filmIds) : null;
            } else {
                $homepageSettings->vimeo_film_ids = null;
            }
            
            $homepageSettings->featured_story_banner_image = $request->featured_story_banner_image;
            $homepageSettings->featured_story_title = $request->featured_story_title;
            $homepageSettings->featured_story_description = $request->featured_story_description;
            $homepageSettings->featured_story_button_text = $request->featured_story_button_text;
            $homepageSettings->featured_story_button_url = $request->featured_story_button_url;
            $homepageSettings->save();

            DB::commit();

            return redirect()
                ->route('admin.homepage-settings.index')
                ->with('success', 'Homepage settings updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Homepage settings update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update homepage settings.')
                ->withInput();
        }
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'section_name' => 'required|string|in:slider_section,content_section',
            'item_type' => 'required|string|in:story,film,gallery',
            'item_id' => 'required|integer',
            'position' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $section = new HomepageSections();
            $section->section_name = $request->section_name;
            $section->item_type = $request->item_type;
            $section->item_id = $request->item_id;
            $section->position = $request->position ?? 0;
            $section->save();

            DB::commit();

            return redirect()
                ->route('admin.homepage-settings.index')
                ->with('success', 'Section item added successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Section store failed: " . $e->getMessage());
            return back()->with('error', 'Failed to add section item.')
                ->withInput();
        }
    }

    public function updateSection(Request $request, $id)
    {
        $request->validate([
            'section_name' => 'required|string|in:slider_section,content_section',
            'item_type' => 'required|string|in:story,film,gallery',
            'item_id' => 'required|integer',
            'position' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $section = HomepageSections::findOrFail($id);
            $section->section_name = $request->section_name;
            $section->item_type = $request->item_type;
            $section->item_id = $request->item_id;
            $section->position = $request->position ?? 0;
            $section->save();

            DB::commit();

            return redirect()
                ->route('admin.homepage-settings.index')
                ->with('success', 'Section item updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Section update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update section item.')
                ->withInput();
        }
    }

    public function destroySection($id)
    {
        DB::beginTransaction();
        try {
            $section = HomepageSections::findOrFail($id);
            $section->delete();

            DB::commit();
            return redirect()
                ->route('admin.homepage-settings.index')
                ->with('success', 'Section item deleted successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Section delete failed: " . $e->getMessage());
            return redirect()->route('admin.homepage-settings.index')
                ->with('error', 'Failed to delete section item.');
        }
    }
}

