<?php

namespace App\Http\Controllers\Admin;

use App\Models\DiscountRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class DiscountRuleController extends Controller
{
    public function index()
    {
        $discountRules = DiscountRule::paginate(10);
        return view('admin.discount_rules.index', compact('discountRules'));
    }

    public function create()
    {
        return view('admin.discount_rules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'min_amount' => 'required|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'max_discount_amount' => 'required|numeric|min:0',
            'is_active' => 'required|in:0,1',
        ]);

        try {
            DiscountRule::create([
                'min_amount' => $request->min_amount,
                'discount_percentage' => $request->discount_percentage,
                'max_discount_amount' => $request->max_discount_amount,
                'is_active' => $request->is_active,
            ]);
            return redirect()->route('admin.discount-rules.index')->with('success', 'Discount rule created successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong, please try again');
        }
    }

    public function edit($id)
    {
        $discountRule = DiscountRule::findOrFail($id);
        return view('admin.discount_rules.edit', compact('discountRule'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'min_amount' => 'required|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'max_discount_amount' => 'required|numeric|min:0',
            'is_active' => 'required|in:0,1',
        ]);

        try {
            $discountRule = DiscountRule::findOrFail($id);
            $discountRule->update([
                'min_amount' => $request->min_amount,
                'discount_percentage' => $request->discount_percentage,
                'max_discount_amount' => $request->max_discount_amount,
                'is_active' => $request->is_active,
            ]);
            return redirect()->route('admin.discount-rules.index')->with('success', 'Discount rule updated successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong, please try again');
        }
    }

    public function destroy($id)
    {
        try {
            $discountRule = DiscountRule::findOrFail($id);
            $discountRule->delete();
            return back()->with('success', 'Discount rule deleted successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong, please try again');
        }
    }
}
