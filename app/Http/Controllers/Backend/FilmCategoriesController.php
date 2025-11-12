<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\FilmCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class FilmCategoriesController extends Controller
{
    public function index()
    {
        try {
            $filmCategories = FilmCategories::orderBy('name')->get();
            return view('backend.film-categories.index', compact('filmCategories'));
        } catch (Exception $e) {
            Log::error("Error fetching film categories: " . $e->getMessage());
            return back()->with('error', 'Failed to load film categories.');
        }
    }

    public function create()
    {
        return view('backend.film-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:film_categories,name',
            'status' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $filmCategory = new FilmCategories();
            $filmCategory->name = $request->name;
            $filmCategory->slug = Str::slug($request->name);
            $filmCategory->status = $request->has('status') ? true : false;

            $filmCategory->save();
            DB::commit();

            return redirect()
                ->route('admin.film-categories.index')
                ->with('success', 'Film category added successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Film category store failed: " . $e->getMessage());
            return back()->with('error', 'Failed to add film category. Please try again.')
                ->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $category = FilmCategories::findOrFail($id);
            return view('backend.film-categories.create', compact('category'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.film-categories.index')
                ->with('error', 'Film category not found.');
        } catch (Exception $e) {
            Log::error("Edit failed: " . $e->getMessage());
            return redirect()->route('admin.film-categories.index')
                ->with('error', 'Something went wrong.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:film_categories,name,' . $id,
            'status' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $category = FilmCategories::findOrFail($id);

            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->status = $request->has('status') ? true : false;
            $category->save();
            DB::commit();

            return redirect()
                ->route('admin.film-categories.index')
                ->with('success', 'Film category updated successfully');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('admin.film-categories.index')
                ->with('error', 'Film category not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update film category.')
                ->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $category = FilmCategories::findOrFail($id);
            $category->delete();

            DB::commit();
            return redirect()
                ->route('admin.film-categories.index')
                ->with('success', 'Film category deleted successfully');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('admin.film-categories.index')
                ->with('error', 'Film category not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Delete failed: " . $e->getMessage());
            return redirect()->route('admin.film-categories.index')
                ->with('error', 'Failed to delete film category.');
        }
    }
}

