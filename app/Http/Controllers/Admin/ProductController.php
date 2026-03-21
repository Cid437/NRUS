<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;

class ProductController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::with('category','brand','primaryPhoto');
            if ($request->input('search.value')) {
                $s = $request->input('search.value');
                $query->where('name','like','%'.$s.'%');
            }
            if ($request->filled('status')) {
                $query->where('is_active',$request->status);
            }
            return DataTables::of($query)
                ->addColumn('category_name', function($product) {
                    return $product->category ? $product->category->name : '';
                })
                ->addColumn('brand_name', function($product) {
                    return $product->brand ? $product->brand->name : '';
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
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'slug'=>'nullable|string|max:255|unique:products,slug',
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0',
            'category_id'=>'nullable|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'is_active'=>'boolean',
            'photo'=>'nullable|image|max:2048',
            'photos'=>'nullable|array',
            'photos.*'=>'nullable|image|max:2048',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product = Product::create($data);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('products','public');
            ProductPhoto::create(["product_id"=>$product->id,"file"=>$path,"is_primary"=>true]);
        }

        if ($request->hasFile('photos') && is_array($request->file('photos'))) {
            foreach ($request->file('photos') as $file) {
                if ($file) {
                    $path = $file->store('products','public');
                    ProductPhoto::create(["product_id"=>$product->id,"file"=>$path]);
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
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'slug'=>'nullable|string|max:255|unique:products,slug,'.$product->id,
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:0',
            'stock'=>'required|integer|min:0',
            'category_id'=>'nullable|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'is_active'=>'boolean',
            'photo'=>'nullable|image|max:2048',
            'photos'=>'nullable|array',
            'photos.*'=>'nullable|image|max:2048',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update($data);

        if ($request->hasFile('photo')) {
            // remove old primary and file from storage
            $oldPrimary = $product->photos()->where('is_primary',true)->first();
            if ($oldPrimary) {
                Storage::disk('public')->delete($oldPrimary->file);
                $oldPrimary->delete();
            }

            $path = $request->file('photo')->store('products','public');
            ProductPhoto::create(["product_id"=>$product->id,"file"=>$path,"is_primary"=>true]);
        }

        if ($request->hasFile('photos') && is_array($request->file('photos'))) {
            foreach ($request->file('photos') as $file) {
                if ($file) {
                    $path = $file->store('products','public');
                    ProductPhoto::create(["product_id"=>$product->id,"file"=>$path]);
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
