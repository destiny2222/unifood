<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminB2BPurchaseOrderController extends Controller
{
    public function index()
    {
        $orders = PurchaseOrder::with(['user', 'items'])
            ->orderBy('id', 'desc')
            ->paginate(50);
            
        return view('admin.b2b_orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = PurchaseOrder::with(['user', 'items.product', 'items.productVariant', 'shippingAddress'])
            ->findOrFail($id);
            
        return view('admin.b2b_orders.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|max:255',
        ]);

        try {
            $order = PurchaseOrder::findOrFail($id);
            $order->update([
                'status' => $request->status,
            ]);
            return back()->with('success', 'B2B Purchase Order updated successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong, please try again');
        }
    }

    public function destroy($id)
    {
        try {
            $order = PurchaseOrder::findOrFail($id);
            $order->items()->delete();
            $order->delete();
            return redirect()->route('admin.b2b-orders.index')->with('success', 'B2B Purchase Order deleted successfully');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Something went wrong, please try again');
        }
    }
}
