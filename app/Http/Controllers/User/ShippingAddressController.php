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
        $validated['user_id'] = Auth::user()->id;
        ShippingAddress::create($validated);
        return back()->with('success',value: 'Shipping Address Added Successfully');
       } catch (\Exception $exception) {
        Log::error($exception->getMessage());
        return back()->with('error',value: 'Something went wrong');
       }
    }
}
