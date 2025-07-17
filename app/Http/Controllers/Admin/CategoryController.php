<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
   public function index(){
        $categories = Category::paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function store(StoreRequest $request){

        // create image 
        // $imageName = null;
        // if($request->hasFile('image')){
        //     $path = $request->file('image');
        //     $image_file = time(). '.'. $path->getClientOriginalExtension();
        //     $manager = new ImageManager( new Driver());
        //     $image = $manager->read($path);
        //     $image->resize(180, 180);
        //     $image->save(public_path('upload/category/'). $image_file);
        // }

        
       try{
            Category::firstOrCreate([
                'title' => $request->title,
                'slug'=>Str::slug($request->title),
                // 'image'=>$image_file,
            ]);
            return redirect()->route('admin.category.index')->with('success', 'Category created successfully');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }

    public function edit($id){
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(UpdateRequest $request, $id){

        // if($request->hasFile('image')){
        //     $path = $request->file('image');
        //     $image_file = time(). '.'. $path->getClientOriginalExtension();
        //     $manager = new ImageManager( new Driver());
        //     $image = $manager->read($path);
        //     $image->resize(180, 180);
        //     $image->save(public_path('upload/category/'). $image_file);
        // }

        try {
            $category = Category::find($id);
            $category->update([
                'title' => $request->title,
                'slug'=>Str::slug($request->title),
                // 'image'=>$image_file ?? $category->image,
            ]);
            return redirect()->route('admin.category.index')->with('success', 'Category updated successfully');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }

    public function destroy($id){
        try{
            $category = Category::find($id);
            $category->delete();
            return back()->with('success', 'Category deleted successfully');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong');
        }
    }
}
