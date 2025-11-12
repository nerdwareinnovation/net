<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FilmCategories;
use App\Models\Films;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class FilmsController extends Controller
{
    public function index()
    {
        try {
            $films = Films::with(['category'])->latest()->get();
            return view('backend.films.index', compact('films'));
        } catch (Exception $e) {
            Log::error("Error fetching films: " . $e->getMessage());
            return back()->with('error', 'Failed to load films.');
        }
    }

    public function create()
    {
        $filmCategories = FilmCategories::where('status', true)->orderBy('name')->get();
        return view('backend.films.create', compact('filmCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'     => 'required|exists:film_categories,id',
            'film_poster'     => 'nullable|string|max:2048',
            'film_banner'     => 'nullable|string|max:2048',
            'release_date'    => 'nullable|date',
            'watch_time'      => 'nullable|string|max:50',
            'trailer_link'    => 'nullable|url|max:500',
            'synopsis'        => 'nullable|string',
            'genre'           => 'nullable|string',
            'tags'            => 'nullable|string',
            'description'     => 'nullable|string',
            'watch_link'      => 'nullable|url|max:500',
            'position'        => 'nullable|integer',
            'status'          => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $film = new Films();
            $film->title = $request->title;
            $film->slug = Str::slug($request->title);
            $film->category_id = $request->category_id;
            $film->film_poster = $request->film_poster;
            $film->film_banner = $request->film_banner;
            $film->release_date = $request->release_date;
            $film->watch_time = $request->watch_time;
            $film->trailer_link = $request->trailer_link;
            $film->synopsis = $request->synopsis;
            $film->description = $request->description;
            $film->watch_link = $request->watch_link;
            $film->position = $request->position ?? 0;
            $film->status = $request->status ?? 'active';

            // Handle genre (comma-separated string to array)
            if($request->genre != ''){
                $genres = array_map('trim', explode(',', $request->input('genre')));
                $film->genre = array_filter($genres);
            }

            // Handle tags (comma-separated string to array)
            if($request->tags != ''){
                $tags = array_map('trim', explode(',', $request->input('tags')));
                $film->tags = array_filter($tags);
            }

            // Handle film_images (multiple)
            if($request->film_images != ''){
                $images = explode(',', $request->input('film_images'));
                $film->film_images = array_filter($images);
            }

            $film->save();
            DB::commit();

            return redirect()
                ->route('admin.films.index')
                ->with('success', 'Film created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Film store failed: " . $e->getMessage());
            return back()->with('error', 'Failed to create film.')->withInput();
        }
    }

    public function show(Films $film)
    {
        return view('backend.films.show', compact('film'));
    }

    public function edit(Films $film)
    {
        $filmCategories = FilmCategories::where('status', true)->orderBy('name')->get();
        return view('backend.films.create', compact('film', 'filmCategories'));
    }

    public function update(Request $request, Films $film)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'category_id'     => 'required|exists:film_categories,id',
            'film_poster'     => 'nullable|string|max:2048',
            'film_banner'     => 'nullable|string|max:2048',
            'release_date'    => 'nullable|date',
            'watch_time'      => 'nullable|string|max:50',
            'trailer_link'    => 'nullable|url|max:500',
            'synopsis'        => 'nullable|string',
            'genre'           => 'nullable|string',
            'tags'            => 'nullable|string',
            'description'     => 'nullable|string',
            'watch_link'      => 'nullable|url|max:500',
            'position'        => 'nullable|integer',
            'status'          => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $film->title = $request->title;
            $film->slug = Str::slug($request->title);
            $film->category_id = $request->category_id;
            $film->film_poster = $request->film_poster;
            $film->film_banner = $request->film_banner;
            $film->release_date = $request->release_date;
            $film->watch_time = $request->watch_time;
            $film->trailer_link = $request->trailer_link;
            $film->synopsis = $request->synopsis;
            $film->description = $request->description;
            $film->watch_link = $request->watch_link;
            $film->position = $request->position ?? 0;
            $film->status = $request->status ?? 'active';

            // Handle genre (comma-separated string to array)
            if($request->genre != ''){
                $genres = array_map('trim', explode(',', $request->input('genre')));
                $film->genre = array_filter($genres);
            } else {
                $film->genre = null;
            }

            // Handle tags (comma-separated string to array)
            if($request->tags != ''){
                $tags = array_map('trim', explode(',', $request->input('tags')));
                $film->tags = array_filter($tags);
            } else {
                $film->tags = null;
            }

            // Handle film_images (multiple)
            if($request->film_images != ''){
                $images = explode(',', $request->input('film_images'));
                $film->film_images = array_filter($images);
            } else {
                $film->film_images = null;
            }

            $film->save();
            DB::commit();

            return redirect()
                ->route('admin.films.index')
                ->with('success', 'Film updated successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Film update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update film.')->withInput();
        }
    }

    public function destroy(Films $film)
    {
        DB::beginTransaction();
        try {
            if ($film->film_poster && Storage::disk('public')->exists($film->film_poster)) {
                Storage::disk('public')->delete($film->film_poster);
            }

            if ($film->film_banner && Storage::disk('public')->exists($film->film_banner)) {
                Storage::disk('public')->delete($film->film_banner);
            }

            if ($film->film_images && is_array($film->film_images)) {
                foreach ($film->film_images as $image) {
                    if ($image && Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                    }
                }
            }

            $film->delete();
            DB::commit();

            return redirect()
                ->route('admin.films.index')
                ->with('success', 'Film deleted successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Film delete failed: " . $e->getMessage());
            return redirect()->route('admin.films.index')
                ->with('error', 'Failed to delete film.');
        }
    }
}

