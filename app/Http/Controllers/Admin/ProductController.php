<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Yajra\DataTables\DataTables;

class ProductController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::with(['category:id,name','brand:id,name','primaryPhoto']);
            if ($request->input('search.value')) {
                $s = $request->input('search.value');
                $query->where('name','like','%'.$s.'%');
            }
            if ($request->filled('status')) {
                $query->where('is_active',$request->status);
            }

            return DataTables::of($query)
                ->addColumn('category_name', function($product) {
                    $catRelation = null;
                    if ($product->relationLoaded('category')) {
                        $catRelation = $product->getRelation('category');
                    } else {
                        $catRelation = $product->category()->first();
                    }

                    if ($catRelation) {
                        return $catRelation->name;
                    }

                    $rawCategory = $product->getAttribute('category');
                    if (is_string($rawCategory) && trim($rawCategory) !== '') {
                        return $rawCategory;
                    }

                    return 'N/A';
                })
                ->addColumn('brand_name', function($product) {
                    return optional($product->brand)->name ?? 'N/A';
                })
                ->addColumn('primary_photo', function($product) {
                    return $product->primaryPhoto ? '<img src="'.asset('storage/'.$product->primaryPhoto->file).'" width="50">' : '';
                })
                ->addColumn('actions', function($product) {
                    return view('admin.products.partials.actions', compact('product'))->render();
                })
                ->rawColumns(['primary_photo','actions'])
                ->make(true);
        }
        return view('admin.products.index');
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:2048',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'slug', 'description', 'price', 'stock', 'category_id', 'brand_id', 'is_active']);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $productId = DB::table('products')->insertGetId($data);

        if ($request->hasFile('photo')) {
            $path = Storage::putFileAs('public/products', $request->file('photo'), $request->file('photo')->hashName());
            DB::table('product_photos')->insert(["product_id" => $productId, "file" => $path, "is_primary" => true]);
        }

        if ($request->hasFile('photos') && is_array($request->file('photos'))) {
            foreach ($request->file('photos') as $file) {
                if ($file) {
                    $path = Storage::putFileAs('public/products', $file, $file->hashName());
                    DB::table('product_photos')->insert(["product_id" => $productId, "file" => $path]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('status','Product created');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,'.$product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'is_active' => 'boolean',
            'photo' => 'nullable|image|max:2048',
            'photos' => 'nullable|array',
            'photos.*' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['name', 'slug', 'description', 'price', 'stock', 'category_id', 'brand_id', 'is_active']);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        DB::table('products')->where('id', $product->id)->update($data);

        if ($request->hasFile('photo')) {
            // remove old primary and file from storage
            $oldPrimary = DB::table('product_photos')->where('product_id', $product->id)->where('is_primary', true)->first();
            if ($oldPrimary) {
                Storage::disk('public')->delete($oldPrimary->file);
                DB::table('product_photos')->where('id', $oldPrimary->id)->delete();
            }

            $path = Storage::putFileAs('public/products', $request->file('photo'), $request->file('photo')->hashName());
            DB::table('product_photos')->insert(["product_id" => $product->id, "file" => $path, "is_primary" => true]);
        }

        if ($request->hasFile('photos') && is_array($request->file('photos'))) {
            foreach ($request->file('photos') as $file) {
                if ($file) {
                    $path = Storage::putFileAs('public/products', $file, $file->hashName());
                    DB::table('product_photos')->insert(["product_id" => $product->id, "file" => $path]);
                }
            }
        }

        return redirect()->route('admin.products.index')->with('status','Product updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('status','Product deleted');
    }

    public function trashed()
    {
        $products = Product::onlyTrashed()->paginate(15);
        return view('admin.products.trashed', compact('products'));
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.products.trashed')->with('status','Product restored');
    }

    public function import(Request $request)
    {
        $request->validate(['file'=>'required|file|mimes:xlsx,xls']);
        Excel::import(new ProductsImport, $request->file('file'));
        return redirect()->route('admin.products.index')->with('status','Import completed');
    }
}
