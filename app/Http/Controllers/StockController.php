<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::all();
        $stocks = Stock::all();
        return view('admin.stock.index', compact('stocks', 'categories', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|numeric|min:1',
            'type' => 'required|in:in,out',
        ]);
        $stock = new Stock();
        $stock->product_id = request('product_id');
        $stock->quantity = request('quantity');
        $stock->type = request('type');
        $stock->save();

        $product = Product::find($request->product_id);
        if ($request->type === 'in') {
            $product->quantity += $request->quantity;
        } else {
            $product->quantity -= $request->quantity;
        }

        $product->save();
        return redirect()->route('stock.index');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|numeric|min:1',
            'type' => 'required|in:in,out',
        ]);
        $stock=Stock::findOrFail($id);
        $a=$stock->quantity;
        $b=$request->quantity;
        $stock->product_id = request('product_id');
        $stock->quantity = request('quantity');
        $stock->type = request('type');
        $stock->update();
        $product=Product::find($request->product_id);
        if($request->type==='in'){
            if (($a-$b)>0){
                $product->quantity-=$a-$b;
            }
            else{
                $product->quantity+=$b-$a;
            }
        }else{
            $product->quantity-=$stock->quantity;
        }
        $product->save();
        return redirect()->route('stock.index');
    }
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        $product = Product::findOrFail($stock->product_id);

        // Mahsulot jadvalidagi quantity ni yangilash
        $product->quantity -= $stock->quantity;
        $product->save();

        // Stock yozuvini o'chirish
        $stock->delete();

        return redirect()->route('stock.index');
    }
}
