<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'model' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|required',
            'percentage' => 'nullable|required',
        ]);
            $file = $request->file('photo');
            $filename = $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
        $product = Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'category_id' => $data['category_id'],
            'model' => $data['model'],
            'photo' => $filename,
            'description' => $data['description'],
            'percentage' => $data['percentage'],
        ]);

        return redirect()->route('products.index');
    }

    public function edit($id)
    {
        $categories = Category::all();
        $product = Product::find($id);
        return view('admin.product.edit', compact('product', 'categories'));

    }

    public function update(Request $request, $id)
    {
        request()->validate([
            'name' => 'required',
            'price' => 'required',
            'category_id' => 'required',
            'model' => 'required',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
//            'quantity'=>'required',
            'description' => 'nullable',
            'percentage' => 'nullable',
        ]);
        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->model = $request->model;
//        $product->quantity=$request->quantity;
        $product->description = $request->description;
        $product->percentage = $request->percentage;
          if ($request->hasFile('photo')) {
              if ($product->photo) {
                  $oldFilePath = public_path('uploads/' . $product->photo);
                  if (file_exists($oldFilePath)) {
                      unlink($oldFilePath);
                  }
              }
              $file = $request->file('photo');
              $filename = time() . '_' . $file->getClientOriginalName();
              $file->move(public_path('uploads'), $filename);
              $product->photo = $filename;
          }
          $product->save();
        return redirect()->route('products.index');
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->photo) {
            $oldFilePath = public_path('uploads/' . $product->photo);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
    public function getProductsByCategory(Request $request)
    {
        $categoryId = $request->query('category');

        $products = Product::where('category_id', $categoryId)->get(['id', 'name']);

        return response()->json(['products' => $products]);
    }

}
