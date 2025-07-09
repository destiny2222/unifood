<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Partner\StoreRequest;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PartnerController extends Controller
{
    public function index(){
        $partners = Partner::orderBy('id', 'desc')->get();
        return view('admin.pages.partner.index', compact('partners'));
    }

    public function create(){
        return view('admin.pages.partner.create');
    }

    public function store(StoreRequest $request){
        $validated = $request->validated();
        try {
            $fileName = null;
            if (request()->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . '.' . $image->getClientOriginalExtension();
                
                $manager = new ImageManager(new Driver());
                $processedImage = $manager->read($image);
                $processedImage->resize(200, 200);
                $processedImage->save(public_path('upload/partner/') . $fileName);
            }
            $validated['image'] = $fileName;
            Partner::create($validated);
            return redirect()->route('admin.partner.index')->with('Created Successful!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public function edit($id){
        $partner = Partner::findOrFail($id);
        return view('admin.pages.partner.edit', compact('partner'));
    }

    public function update(StoreRequest $request, $id){
        $validated = $request->validated();
        try {
            $fileName = null;
            if (request()->hasFile('image')) {
                $image = $request->file('image');
                $fileName = time() . '.' . $image->getClientOriginalExtension();
                
                $manager = new ImageManager(new Driver());
                $processedImage = $manager->read($image);
                $processedImage->resize(200, 200);
                $processedImage->save(public_path('upload/partner/') . $fileName);
            }
            $partner = Partner::findOrFail($id);
            $validated['image'] = $fileName ? $fileName : $partner->image;
            $partner->update($validated);
            return redirect()->route('admin.partner.index')->with('Created Successful!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }

    public function destroy($id){
        try {
            $partner = Partner::findOrFail($id);
            $partner->delete();
            return redirect()->route('admin.partner.index')->with('Deleted Successful!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went worry');
        }
    }
}
