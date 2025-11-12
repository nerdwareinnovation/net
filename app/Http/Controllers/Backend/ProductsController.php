<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Helpers\CustomFieldHelper;
use App\Models\CustomField;
use App\Models\ProductCategories;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ProductsController extends Controller
{
    public function index()
    {
        try {
            $products = Products::with('category')->latest()->get();

            return view('backend.products.index', compact('products'));
        } catch (Exception $e) {
            Log::error("Error fetching products: " . $e->getMessage());
            return back()->with('error', 'Failed to load products.');
        }
    }

    public function create()
    {
        $categories = ProductCategories::all();
        $custom_fields = CustomField::where('model_type', 'App\Models\Products')->get();

        return view('backend.products.create', compact('categories','custom_fields'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|string|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $product = new Products();
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->image = $request->image;
            if($request->images != ''){
                $images = explode(',', $request->input('images'));
                $product->images     = $images;

            }
            $product->save();
            CustomFieldHelper::saveResponses($product, $request->input('custom_fields', []));

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Product store failed: " . $e->getMessage());
            return back()->with('error', 'Failed to create product.')->withInput();
        }
    }

    public function edit($id)
    {
        try {
            $product = Products::findOrFail($id);
            $categories = ProductCategories::all();
            $custom_fields = CustomField::where('model_type', 'App\Models\Products')->get();

            return view('backend.products.create', compact('product', 'categories','custom_fields'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Product not found.');
        } catch (Exception $e) {
            Log::error("Product edit failed: " . $e->getMessage());
            return redirect()->route('admin.products.index')
                ->with('error', 'Something went wrong.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|string|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $product = Products::findOrFail($id);

            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->description = $request->description;
            $product->image = $request->image;
            if($request->images != ''){
                $images = explode(',', $request->input('images'));
                $product->images     = $images;

            }
            $product->save();
            CustomFieldHelper::updateResponses($product, $request->input('custom_fields', []));

            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product updated successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('admin.products.index')
                ->with('error', 'Product not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Product update failed: " . $e->getMessage());
            return back()->with('error', 'Failed to update product.')->withInput();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Products::findOrFail($id);

            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();
            DB::commit();

            return redirect()
                ->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('admin.products.index')
                ->with('error', 'Product not found.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Product delete failed: " . $e->getMessage());
            return redirect()->route('admin.products.index')
                ->with('error', 'Failed to delete product.');
        }
    }
}

