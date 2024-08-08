<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs=Blog::latest()->paginate(12);
        return view('admin.blog.index', compact('blogs'));
    }
    public function create()
    {
        return view('admin.blog.create');
    }
    public function store(Request $request){
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $file = $request->file('photo');
        $filename = $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);
        $blog=Blog::create([
            'title'=>$request->title,
            'photo'=>$filename,
            'description'=>$request->description
        ]);
        return redirect()->route('blogs.index');
    }

    public function edit($id)
    {
        $blog=Blog::findOrFail($id);
        return view('admin.blog.edit', compact('blog'));

    }
    public function update(Request $request, $id){
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $blog=Blog::findOrFail($id);
        $blog->title=$request->title;
        $blog->description=$request->description;
        if($request->file('photo')){
            if ($product->photo) {
                $oldFilePath = public_path('uploads/' . $product->photo);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $blog->photo = $filename;
        }
        $blog->save();
        return redirect()->route('blogs.index');
    }
}
