<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function edit($id)
    {
        $order = OrderItem::with(['product', 'shippingAddress.deliveryArea'])->findOrFail($id);
        return view('partials.order_details', compact('order'));
    }


}
