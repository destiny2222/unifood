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
use App\Traits\CloudinaryUploadTrait;


class ProductController extends Controller
{
    use CloudinaryUploadTrait;
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

            $result = null;
            if ($request->hasFile('image')) {
                $result = $this->uploadImageToCloudinary($request->file('image'), 'mightyolu/upload/product/single');
                // $imageFile = $request->file('image');
                // $filename = time() . '_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                // $path = $imageFile->storeAs('upload/product/single', $filename, 'public');
                // $image = $filename; // Save only the filename to the database
            }


            $new_product = Product::firstOrCreate([
                'title' => $request->title,
                'price' => $request->price,
                'slug'=>Str::slug($request->title),
                'availability'=>$request->availability,
                'featured'=>$request->featured,
                'badge'=>$request->badge,
                'price'=>$request->price,
                'images'=>$result['secure_url'],
                'weight' => $request->weight,
                'weight_unit' => $request->weight_unit,
                'discount'=>$request->discount,
                'status'=>$request->status,
                'category_id'=>$request->category_id,
                'description'=>$request->description,
            ]);

            if($request->has('images')){
                 $imageResults = $this->uploadMultipleToCloudinary(
                    $request->images, 
                    'mightyolu/upload/images', 
                    'image'
                );
                foreach ($imageResults as $result) {
                    if ($result['success']) {
                        ProductImage::create([
                            'product_id' => $new_product->id,
                            // 'image_url' => $result['secure_url'],
                            'image_path' => $result['secure_url'],
                        ]);
                    } else {
                        Log::error('Failed to upload image: ' . $result['error']);
                    }
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

            $result = null;
            if ($request->hasFile('image')) {
                $result = $this->uploadImageToCloudinary($request->file('image'), 'mightyolu/upload/product/single');
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
                'weight' => $request->weight,
                'weight_unit' => $request->weight_unit,
                'description'=>$request->description,
                'category_id'=>$request->category_id,
                'images'=> $result['secure_url'] ?? $product->images,
            ]);

            $productImages = ProductImage::where('product_id', $product->id)->get();
            if($request->has('images')){
                 $imageResults = $this->uploadMultipleToCloudinary(
                    $request->images, 
                    'mightyolu/upload/images', 
                    'image'
                );
                foreach ($imageResults as $result) {
                    if ($result['success']) {
                        ProductImage::create([
                            'product_id' => $productImages->id,
                            // 'image_url' => $result['secure_url'],
                            'image_path' => $result['secure_url'] ?? $productImages->image_path,
                            // 'image_public_id' => $result['public_id'],
                        ]);
                    } else {
                        Log::error('Failed to upload image: ' . $result['error']);
                    }
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
