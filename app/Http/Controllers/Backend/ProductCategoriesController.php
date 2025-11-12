<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ProductCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ProductCategoriesController extends Controller
{
    public function index()
    {
        try {
            $categories = ProductCategories::latest()->get();
            return view('backend.product-categories.index', compact('categories'));
        } catch (Exception $e) {
            Log::error("Error fetching product categories: " . $e->getMessage());
            return back()->with('error', 'Failed to load product categories.');
        }
    }

    public function create()
    {
        return view('backend.product-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:product_categories,name',
            'description' => 'nullable|string',
            'image'       => 'nullable|string|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $category = new ProductCategories();
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->description = $request->description;

            $category->image = $request->image;
            $category->save();
            DB::commit();

            return redirect()
                ->route('admin.product-categories.index')
                ->with('success', 'Category added successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Product category store failed: " . $e->getMessage());
            return back()->with('error', 'Failed to add category.')->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $category = ProductCategories::findOrFail($id);
            return view('backend.product-categories.create', compact('category'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Category not found.');
        } catch (Exception $e) {
            Log::error("Product category edit failed: " . $e->getMessage());
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Something went wrong.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255|unique:product_categories,name,' . $id,
            'description' => 'nullable|string',
            'image'       => 'nullable|string|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $category = ProductCategories::findOrFail($id);

            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->description = $request->description;
            $category->image = $request->image;


            $category->save();
            DB::commit();

            return redirect()
                ->route('admin.product-categories.index')
                ->with('success', 'Category updated successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Category not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Product category update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update category.')->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $category = ProductCategories::findOrFail($id);

            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();
            DB::commit();

            return redirect()
                ->route('admin.product-categories.index')
                ->with('success', 'Category deleted successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Category not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Product category delete failed: " . $e->getMessage());
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Failed to delete category.');
        }
    }
}

