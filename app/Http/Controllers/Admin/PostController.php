<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\StoreRequest;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PostController extends Controller
{
     public function index(){
        $post = Post::orderBy('id', 'desc')->paginate(10);
        return view('admin.post.index',[
            'posts'=>$post,
        ]);
    }

    public function create(){
        $categories = PostCategory::orderBy('id', 'desc')->get();
        return view('admin.post.create', [
            'categories'=>$categories,
        ]);
    }

     public function store(StoreRequest $request){
        $validated = $request->validated();
           
        try {
            $imageName = null;
            if (request()->hasFile('image')) {
                $image = request()->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                // Store the original image
                $path = $image->storeAs('upload/post', $imageName, 'public');
                // Process the image
                $manager = new ImageManager(new Driver());
                $img = $manager->read(storage_path('app/public/' . $path));
                $img->resize(600, 600);
                $img->save(storage_path('app/public/' . $path));

                // $manager = new ImageManager(new Driver());
                // $processedImage = $manager->read($image);
                // $processedImage->resize(500, 321);
                // $processedImage->save(public_path('upload/post/') . $imageName);
            }
            $validated['image'] = $imageName;
            $validated['slug'] = Str::slug($validated['title']);
            Post::create($validated);
            return redirect()->route('admin.post.index')->with('success', 'Post created successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->route('admin.post.index')->with('error', 'Something went wrong');
        }
    }

    public function edit($id){
        $categories = PostCategory::orderBy('id', 'desc')->get();
        $post = Post::findOrFail($id);
        return view('admin.post.edit', [
            'categories'=>$categories,
            'post'=>$post
        ]);
    }

    public function update(StoreRequest $request, $id){
        $validated = $request->validated();

        try {
            
            if ($request->hasFile('image')) {
                $image = request()->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                // Store the original image
                $path = $image->storeAs('upload/post', $imageName, 'public');
                // Process the image
                $manager = new ImageManager(new Driver());
                $img = $manager->read(storage_path('app/public/' . $path));
                $img->resize(600, 600);
                $img->save(storage_path('app/public/' . $path));
            }
            
            $post = Post::findOrFail($id);
            $validated['slug'] = Str::slug($validated['title']);
            $validated['image'] = $imageName ?? $post->image;
            $post->update($validated);
            return redirect()->route('admin.post.index')->with('success', 'Post updated successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->route('admin.post.index')->with('error', 'Something went wrong');
        }
    }

    public function destroy($id){
        try {
            $post = Post::findOrFail($id);
            $post->delete();
            return redirect()->route('admin.post.index')->with('success', 'Post deleted successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->route('admin.post.index')->with('error', 'Something went wrong');
        }
    }
}
