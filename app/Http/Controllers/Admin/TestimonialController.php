<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Testimonial\StoreRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TestimonialController extends Controller
{
    public function index(){
        $testimonials = Testimonial::orderBy('id', 'desc')->get();
        return view('admin.pages.testimonial.index', compact('testimonials'));
    }

    public function create(){
        return view('admin.pages.testimonial.create');
    }

     public function store(StoreRequest  $request){
        $validated = $request->validated();
        try {
            $imageName = null;
            if (request()->hasFile('existing_image')) {
                $image = $request->file('existing_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                $manager = new ImageManager(new Driver());
                $processedImage = $manager->read($image);
                $processedImage->resize(200, 200);
                $processedImage->save(public_path('upload/testimonial/') . $imageName);
            }
            $fileName = null;
            if ($request->hasFile('product_image')) {
                $image = $request->file('product_image');
                $fileName = time() . '.' . $image->getClientOriginalExtension();
                
                $manager = new ImageManager(new Driver());
                $processedImage = $manager->read($image);
                $processedImage->resize(200, 200);
                $processedImage->save(public_path('upload/testimonial/product/') . $fileName);
            }
            $validated['existing_image'] = $imageName;
            $validated['product_image'] = $fileName;
            Testimonial::create($validated);
            return redirect()->route('admin.testimonial.index')->with('Created Successful!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public function edit($id){
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.pages.testimonial.edit', compact('testimonial'));
    }

    public function update(StoreRequest $request, $id){
        $validated = $request->validated();
        try {
            $imageName = null;
            if (request()->hasFile('existing_image')) {
                $image = $request->file('existing_image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                $manager = new ImageManager(new Driver());
                $processedImage = $manager->read($image);
                $processedImage->resize(200, 200);
                $processedImage->save(public_path('upload/testimonial/') . $imageName);
            }
            $fileName = null;
            if ($request->hasFile('product_image')) {
                $image = $request->file('product_image');
                $fileName = time() . '.' . $image->getClientOriginalExtension();
                
                $manager = new ImageManager(new Driver());
                $processedImage = $manager->read($image);
                $processedImage->resize(200, 200);
                $processedImage->save(public_path('upload/testimonial/product/') . $fileName);
            }
            $testimonial = Testimonial::findOrFail($id);
            $validated['existing_image'] = $imageName ? $imageName : $testimonial->existing_image;
            $validated['product_image'] = $fileName ? $fileName : $testimonial->product_image;
            $testimonial->update($validated);
            return redirect()->route('admin.testimonial.index')->with('Updated Successful!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public function destroy($id){
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();
        return back()->with('success', 'Delete Successful!');
    }
}
