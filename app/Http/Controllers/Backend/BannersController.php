<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Banners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class BannersController extends Controller
{
    public function index()
    {
        try {
            $banners = Banners::orderBy('position')->orderBy('created_at', 'desc')->get();
            return view('backend.banners.index', compact('banners'));
        } catch (Exception $e) {
            Log::error("Error fetching banners: " . $e->getMessage());
            return back()->with('error', 'Failed to load banners.');
        }
    }

    public function create()
    {
        return view('backend.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'position' => 'nullable|integer',
            'status' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|url|max:500',
        ]);

        DB::beginTransaction();
        try {
            $banner = new Banners();
            $banner->title = $request->title;
            $banner->short_description = $request->short_description;
            $banner->image = $request->image;
            $banner->position = $request->position ?? 0;
            $banner->status = $request->status ?? 'active';
            $banner->button_text = $request->button_text;
            $banner->button_url = $request->button_url;
            $banner->save();

            DB::commit();

            return redirect()
                ->route('admin.banners.index')
                ->with('success', 'Banner created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Banner store failed: " . $e->getMessage());
            return back()->with('error', 'Failed to create banner.')->withInput();
        }
    }

    public function edit(Banners $banner)
    {
        return view('backend.banners.create', compact('banner'));
    }

    public function update(Request $request, Banners $banner)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'image' => 'nullable|string|max:2048',
            'position' => 'nullable|integer',
            'status' => 'nullable|string',
            'button_text' => 'nullable|string|max:255',
            'button_url' => 'nullable|url|max:500',
        ]);

        DB::beginTransaction();
        try {
            $banner->title = $request->title;
            $banner->short_description = $request->short_description;
            $banner->image = $request->image;
            $banner->position = $request->position ?? 0;
            $banner->status = $request->status ?? 'active';
            $banner->button_text = $request->button_text;
            $banner->button_url = $request->button_url;
            $banner->save();

            DB::commit();

            return redirect()
                ->route('admin.banners.index')
                ->with('success', 'Banner updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Banner update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update banner.')->withInput();
        }
    }

    public function destroy(Banners $banner)
    {
        DB::beginTransaction();
        try {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $banner->delete();
            DB::commit();

            return redirect()
                ->route('admin.banners.index')
                ->with('success', 'Banner deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Banner delete failed: " . $e->getMessage());
            return redirect()->route('admin.banners.index')
                ->with('error', 'Failed to delete banner.');
        }
    }
}

