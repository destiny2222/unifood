<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\Category\StoreRequest;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function index(){
        $categories = PostCategory::paginate(10);
        return view('admin.post.category.index', compact('categories'));
    }

    public function create(){
        return view('admin.post.category.create');
    }

    public function store(StoreRequest $request){

        $validated = $request->validated();
        try {
            $validated['slug'] = Str::slug($validated['title']);
            PostCategory::create($validated);
            return redirect()->route('admin.post.category.index')->with('success', 'Category created successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id){
        try{
          $category = PostCategory::find($id);
          return view('admin.post.category.edit', compact('category'));
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong');
        }
        
    }

    public function update(StoreRequest $request, $id){
        try{
            $validated = $request->validated();
            $validated['slug'] = Str::slug($validated['title']);
            $category = PostCategory::find($id);
            $category->update($validated);
            return redirect()->route('admin.post.category.index')->with('success', 'Category updated successfully');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong');
        } 
    }

    public function destroy($id){
        try {
            $category = PostCategory::find($id);
            $category->delete();
            return back()->with('success', 'Category deleted successfully');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong');
        } 

        
    }
}
