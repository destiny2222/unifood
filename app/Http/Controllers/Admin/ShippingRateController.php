<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use Illuminate\Http\Request;

class ShippingRateController extends Controller
{
    public function index()
    {
        $shippingRates = ShippingRate::paginate(10);
        return view('admin.shippingRate.index', compact('shippingRates'));
    }

    public function create()
    {
        return view('admin.shippingRate.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'min_weight' => 'required|numeric|min:0',
            'max_weight' => 'required|numeric|gte:min_weight',
            'delivery_type' => 'required|in:next_day,next_morning,two_days',
            'price' => 'required|numeric|min:0',
        ]);

        ShippingRate::create($request->only([
            'min_weight',
            'max_weight',
            'delivery_type',
            'price'
        ]));

        return redirect()->route('admin.shipping.rate.index')
            ->with('success', 'Shipping rate created successfully.');
    }

    public function edit($id)
    {
        $rate = ShippingRate::findOrFail($id);
        return view('admin.shippingRate.edit', compact('rate'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'min_weight' => 'required|numeric|min:0',
            'max_weight' => 'required|numeric|gte:min_weight',
            'delivery_type' => 'required|in:next_day,next_morning,two_days',
            'price' => 'required|numeric|min:0',
        ]);

        $shippingRate = ShippingRate::findOrFail($id);
        $shippingRate->update($request->only([
            'min_weight',
            'max_weight',
            'delivery_type',
            'price'
        ]));

        return redirect()->route('admin.shipping.rate.index')
            ->with('success', 'Shipping rate updated successfully.');
    }

    public function destroy($id)
    {
        $shippingRate = ShippingRate::findOrFail($id);
        $shippingRate->delete();

        return redirect()->route('admin.shipping.rate.index')
            ->with('success', 'Shipping rate deleted successfully.');
    }
}
