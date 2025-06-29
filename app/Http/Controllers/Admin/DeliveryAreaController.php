<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryRequest;
use App\Models\DeliveryArea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DeliveryAreaController extends Controller
{
    public function index(){
        $delivery = DeliveryArea::orderBy('id', 'desc')->get();
        return view('admin.deliveryArea.index', [
            'deliveries' => $delivery
        ]);
    }

    public function create(){
        return view('admin.deliveryArea.create');
    }

    public function store(DeliveryRequest $request){
        try {
            $validated = $request->validated();
            $validated['slug'] = Str::slug($validated['area_name']);
            DeliveryArea::create($validated);
            return redirect()->route('admin.delivery.area.index')->with('success', 'Delivery Area Added Successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('admin.delivery.area.index')->with('error', 'Something went wrong');
        }
    }

    public function edit($id){
        $deliveryArea = DeliveryArea::findOrFail($id);
        return view('admin.deliveryArea.edit', compact('deliveryArea'));
    }

    public function update(DeliveryRequest $request, $id){
        try {
            $validated = $request->validated();
            $validated['slug'] = Str::slug($validated['area_name']);
            $deliveryArea = DeliveryArea::find($id);
            $deliveryArea->update($validated);
            return redirect()->route('admin.delivery.area.index')->with('success', 'Delivery Area Updated Successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('admin.delivery.area.index')->with('error', 'Something went wrong');
        }
    }

    public function destroy($id){
        try {
            $deliveryArea = DeliveryArea::find($id);
            $deliveryArea->delete();
            return redirect()->route('admin.delivery.area.index')->with('success', 'Delivery Area Deleted Successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('admin.delivery.area.index')->with('error', 'Something went wrong');
        }
    }
}
