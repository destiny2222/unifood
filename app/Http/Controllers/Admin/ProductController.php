<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Traits\ProductHelper;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\Admin\Product\UpdateRequest;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    public function index(){
        $products = Product::orderBy('id', 'desc')->paginate(10);
        return view('admin.product.index', compact('products'));
    }

    public function create(){
        $categories = Category::orderBy('id','desc')->get();
        return view('admin.product.create', [
            'categories' => $categories,
        ]);
    }


    public function store(StoreRequest $request){

        // dd($request->all());

        try{

            $image = null;
            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $path = $imageFile->storeAs('upload/product/single', $filename, 'public');
                $image = $filename; // Save only the filename to the database
            }


            $new_product = Product::firstOrCreate([
                'title' => $request->title,
                'price' => $request->price,
                'slug'=>Str::slug($request->title),
                'availability'=>$request->availability,
                'featured'=>$request->featured,
                'badge'=>$request->badge,
                'price'=>$request->price,
                'images'=>$image,
                'discount'=>$request->discount,
                'status'=>$request->status,
                'category_id'=>$request->category_id,
                'description'=>$request->description,
            ]);
            
            if($request->hasFile('images')){
                foreach($request->file('images') as $image){
                    // Generate a unique filename
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    
                    // Store the original image
                    $path = $image->storeAs('upload/product', $filename, 'public');
                    
                    // Process the image
                    $manager = new ImageManager(new Driver());
                    $img = $manager->read(storage_path('app/public/' . $path));
                    $img->resize(600, 600);
                    $img->save(storage_path('app/public/' . $path));
                    
                    // Create image record - save ONLY the filename
                    ProductImage::create([
                        'product_id' => $new_product->id,
                        'image_path' => $filename  // Changed from $path to $filename
                    ]);
                }
            }
            return redirect()->route('admin.product.index')->with('success', 'Product created successfully');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return back()->with('error', 'Something went wrong while creating product.');
        }
        
    }

    public function edit($id){
        $product = Product::find($id);
        $categories = Category::orderBy('id','desc')->get();
        return view('admin.product.edit',[
            'categories' => $categories,
            'product' => $product, 
        ]);
    }

    public function update(UpdateRequest $request, $id){
       try {
            $product  = Product::findOrFail($id);

            $image = null;
            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $filename = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $path = $imageFile->storeAs('upload/product/single', $filename, 'public');
                $image = $filename; // Save only the filename to the database
            }



            $product->update([
                'title' => $request->title,
                'price' => $request->price,
                'availability'=>$request->availability,
                'featured'=>$request->featured,
                'badge'=>$request->badge,
                'slug'=>Str::slug($request->title),
                'price'=>$request->price,
                'discount'=>$request->discount,
                'description'=>$request->description,
                'category_id'=>$request->category_id,
                'images'=>$image ?? $product->image,
            ]);

            if($request->has('images')){
                foreach($request->file('images') as $image){
                    // Generate a unique filename
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    
                    // Store the original image
                    $path = $image->storeAs('upload/product', $filename, 'public');
                    
                    // Process the image
                    $manager = new ImageManager(new Driver());
                    $img = $manager->read(storage_path('app/public/' . $path));
                    $img->resize(600, 600);
                    $img->save(storage_path('app/public/' . $path));
                    
                    // Create image record - save ONLY the filename
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $filename  // Changed from $path to $filename
                    ]);
                }
            }
            return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
       } catch (\Exception $exception) {
         Log::error($exception->getMessage());
         return back()->with('error', 'Something went wrong, please try again later');
       }
    }

    public function destroy($id){
        try{
            $product = Product::find($id);
            $product->delete();
            return redirect()->route('admin.product.index')->with('success', 'Product deleted successfully');
        }catch( \Exception $exception){
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong, please try again later');
        }
    }
}
