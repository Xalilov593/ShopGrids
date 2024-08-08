<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public  function product_page()
    {
        $products = Product::take(2)->get();
        $products_main = Product::skip(2)->take(8)->get();
        $product1 = Product::where('id', 19)->first();
        $product2 = Product::where('id', 20)->first();
        return view('front.home',compact('products', 'products_main', 'product1', 'product2'));
    }
    public  function product_detail($id){
        $product=Product::findOrFail($id);
        return view('front.show', compact('product'));
    }

    public function blog_page()
    {
        $blogs = Blog::take(2)->get();
        return view('front.blog', compact('blogs'));
    }
    public function blog_detail($id)
    {
       $blog=Blog::findOrFail($id);
       return view('front.show_blog', compact('blog'));
    }
    public  function contact_page()
    {
        return view('front.contact');
    }
    public  function cart_page(Request $request)
    {
        $products = $request->get('products');
        $ids = [];
        $data = [];
        foreach ($products ?? [] as $product){
            $ids[] = $product['id'];
        }
        if (!empty($ids)){
            $data = Product::whereIn('id', $ids)->get();
        }


        return view('front.cart',[
            'products' => $data,
            'qnts' => $products,
        ]);

    }

}
