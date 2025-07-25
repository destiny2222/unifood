<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingRequest;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShippingAddressController extends Controller
{
    public function store(ShippingRequest $request){
       $validated = $request->validated();
       try {
        
        $validated['is_default'] = $request->has('is_default');
        $validated['user_id'] = Auth::user()->id;
        ShippingAddress::create($validated);
        return back()->with('success',value: 'Shipping Address Added Successfully');
       } catch (\Exception $exception) {
        Log::error($exception->getMessage());
        return back()->with('error',value: 'Something went wrong');
       }
    }

    public function edit($id)
{
    try {
        $shippingAddress = ShippingAddress::with('deliveryArea')->findOrFail($id);
        return response()->json([
            'data' => [
                'id' => $shippingAddress->id,
                'first_name' => $shippingAddress->first_name,
                'last_name' => $shippingAddress->last_name,
                'phone_number' => $shippingAddress->phone_number,
                'email' => $shippingAddress->email,
                'address' => $shippingAddress->address,
                'delivery_area_id' => $shippingAddress->delivery_area_id,
                'delivery_area_name' => $shippingAddress->deliveryArea->delivery_area_name ?? '',
                'address_type' => $shippingAddress->address_type,
            ]
        ]);
    } catch (\Exception $exception) {
        Log::error($exception->getMessage());
        return response()->json(['error' => 'Something went wrong'], 500);
    }
}

    public function update(ShippingRequest $request, $id){
        $validated = $request->validated();
        try {
            $validated['user_id'] = Auth::user()->id;
            $shippingAddress = ShippingAddress::findOrFail($id);
            $shippingAddress->update($validated);
            // ShippingAddress::where('id', $request->id)->update($validated);
            return back()->with('success',value: 'Shipping Address Updated Successfully');
           } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error',value: 'Something went wrong');
        }
    }

    // public function update(ShippingRequest $request, $id)
    // {
    //     $validated = $request->validated();
    //     try {
    //         $validated['user_id'] = Auth::id();
    //         $shippingAddress = ShippingAddress::findOrFail($id);
    //         $shippingAddress->update($validated);

    //         // Fetch updated list of shipping addresses
    //         $shippingAddresses = ShippingAddress::where('user_id', Auth::id())->get();

    //         // Render the address list partial view as HTML string
    //         // $html = view('partials.address_list', compact('shippingAddresses'))->render();

    //         return response()->json([
    //             'message' => 'Shipping Address Updated Successfully',
    //             // 'html' => $html,
    //         ]);
    //     } catch (\Exception $exception) {
    //         Log::error($exception->getMessage());
    //         return response()->json([
    //             'message' => 'Something went wrong',
    //         ], 500);
    //     }
    // }


    public function destroy($id){
        try {
            $shippingAddress = ShippingAddress::findOrFail($id);
            $shippingAddress->delete();
            return back()->with('success',value: 'Shipping Address Deleted Successfully');
           } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error',value: 'Something went wrong');
        }
    }
}
