<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Slider\StoreRequest;
use App\Traits\CloudinaryUploadTrait;
use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class SliderController extends Controller
{
    use CloudinaryUploadTrait;
    public function index(){
        $sliders = Slider::orderBy('id', 'desc')->get();
        return view('admin.pages.slider.index', compact('sliders'));
    }

    public function create(){
        return view('admin.pages.slider.create');
    }

    public function store(StoreRequest  $request){
        $validated = $request->validated();
        try {
            $imageName = null;
            if ($request->hasFile('image')) {
                $imageName = $this->uploadImageToCloudinary($request->file('image'), 'mightyolu/upload/slider');
                // $image = $request->file('image');
                // $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                // $manager = new ImageManager(new Driver());
                // $processedImage = $manager->read($image);
                // $processedImage->resize(200, 200);
                // $processedImage->save(public_path('upload/slider/') . $imageName);
            }
            $validated['image'] = $imageName['secure_url'];
            Slider::create($validated);
            return redirect()->route('admin.slider.index')->with('Successful! Updated!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public  function edit($id){
        $slider = Slider::findOrFail($id);
        return view('admin.pages.slider.edit', compact('slider'));
    }

    public function update(StoreRequest $request, $id){
        $validated = $request->validated();
        try {
            $slider = Slider::findOrFail($id);
            $imageName = $slider->image;
            if ($request->hasFile('image')) {
                $imageName = $this->uploadImageToCloudinary($request->file('image'), 'mightyolu/upload/slider');
                // $image = $request->file('image');
                // $imageName = time() . '.' . $image->getClientOriginalExtension();
                
                // $manager = new ImageManager(new Driver());
                // $processedImage = $manager->read($image);
                // $processedImage->resize(200, 200);
                // $processedImage->save(public_path('upload/slider/') . $imageName);
            }
            $slider = Slider::findOrFail($id);
            $validated['image'] = $imageName['secure_url'] ?? $slider->image;
            $slider->update($validated);
            return redirect()->route('admin.slider.index')->with('Successful! Updated!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public function destroy($id){
        try {
            $slider = Slider::findOrFail($id);
            $slider->delete();
            return redirect()->route('admin.slider.index')->with('Successful! Deleted!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }
}
