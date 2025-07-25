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

        $validatedData = $request->validated();
        
        try{

          

            $result = null;
            if ($request->hasFile('image')) {
                $result = $this->uploadImageToCloudinary($request->file('image'), 'mightyolu/upload/product/single');
            }

            $validatedData['slug'] = Str::slug($request->title);
            $validatedData['images'] = $result['secure_url'] ?? null;

            $new_product = Product::firstOrCreate($validatedData);
            
            foreach ($request->variants as $variant) {
                $new_product->variants()->create([
                    'size'   => $variant['size'],
                    'weight' => $variant['weight'],
                    'unit'   => $variant['unit'],
                    'price'  => $variant['price'],
                ]);
            }

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
        $validatedData = $request->validated();
       try {
            $product  = Product::findOrFail($id);

            $result = null;
            if ($request->hasFile('image')) {
                $result = $this->uploadImageToCloudinary($request->file('image'), 'mightyolu/upload/product/single');
            }


            $validatedData['slug'] = Str::slug($request->title);
            $validatedData['images'] = $result['secure_url'] ?? $product->images;

            $product->update($validatedData);

            $variantIds = [];

            
            if ($request->has('variants') && is_array($request->variants)) {
                foreach ($request->variants as $variant) {
                    if (isset($variant['_destroy']) && $variant['_destroy'] == '1') {
                        if (!empty($variant['id'])) {
                            $product->variants()->where('id', $variant['id'])->delete();
                        }
                        continue; 
                    }

                    if (!empty($variant['id'])) {
                        $existingVariant = $product->variants()->where('id', $variant['id'])->first();
                        if ($existingVariant) {
                            $existingVariant->update([
                                'size'   => $variant['size'],
                                'weight' => $variant['weight'],
                                'unit'   => $variant['unit'],
                                'price'  => $variant['price'],
                            ]);
                            $variantIds[] = $existingVariant->id;
                        }
                    } else {
                        $newVariant = $product->variants()->create([
                            'size'   => $variant['size'],
                            'weight' => $variant['weight'],
                            'unit'   => $variant['unit'],
                            'price'  => $variant['price'],
                        ]);
                        $variantIds[] = $newVariant->id;
                    }
                }
            }
            


            $productImages = ProductImage::where('product_id', $product->id)->get();

            if($request->has('images')){
                 $imageResults = $this->uploadMultipleToCloudinary(
                    $request->images, 
                    'mightyolu/upload/images', 
                    'image'
                );
                foreach ($imageResults as $result) {
                    if ($result['success']) {
                        $productImages->update([
                            'product_id' => $product->id,
                            'image_path' => $result['secure_url'] ?? $productImages->image_path,
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
