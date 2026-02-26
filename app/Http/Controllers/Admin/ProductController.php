<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category','brand');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('name','like','%'.$s.'%');
        }
        if ($request->filled('status')) {
            $query->where('is_active',$request->status);
        }
        $products = $query->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
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
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('products','public');
                ProductPhoto::create(["product_id"=>$product->id,"file"=>$path]);
            }
        }

        return redirect()->route('admin.products.index')->with('status','Product created');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
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
            'photos.*'=>'nullable|image|max:2048',
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update($data);

        if ($request->hasFile('photo')) {
            // remove old primary
            $product->photos()->where('is_primary',true)->delete();
            $path = $request->file('photo')->store('products','public');
            ProductPhoto::create(["product_id"=>$product->id,"file"=>$path,"is_primary"=>true]);
        }
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('products','public');
                ProductPhoto::create(["product_id"=>$product->id,"file"=>$path]);
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
        $request->validate(['file'=>'required|file']);
        $path = $request->file('file')->getRealPath();
        // simple csv import
        if (($handle = fopen($path,'r')) !== false) {
            $header = fgetcsv($handle,1000,',');
            while (($row = fgetcsv($handle,1000,',')) !== false) {
                $data = array_combine($header,$row);
                Product::updateOrCreate(['slug'=>$data['slug'] ?? Str::slug($data['name'])], [
                    'name'=>$data['name'],
                    'description'=>$data['description'] ?? null,
                    'price'=>$data['price'] ?? 0,
                    'stock'=>$data['stock'] ?? 0,
                    'is_active'=>$data['is_active'] ?? 1,
                ]);
            }
            fclose($handle);
        }
        return redirect()->route('admin.products.index')->with('status','Import completed');
    }
}
