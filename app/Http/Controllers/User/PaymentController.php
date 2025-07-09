<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Notifications\OrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Stripe\Stripe;
use Illuminate\Support\Facades\Notification;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
   public function stripeCheckout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // dd($request->total_price);

        try {
            $redirectUrl = route('stripe.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}';
            $response = Session::create([
                'success_url' => $redirectUrl,
                'payment_method_types' => ['link', 'card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Laravel Stripe Payment',
                        ],
                        'unit_amount' => 100 * $request->total_price, // $10.00 in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'allow_promotion_codes' => false,
                'cancel_url' => route('stripe.checkout.cancel'),
                'metadata' => [
                    'order_item_ids' => is_array($request->order_item_ids) ? implode(',', $request->order_item_ids) : $request->order_item_ids,
                    'invoice_number' => $request->invoice_number,
                    'user_id' => Auth::user()->id,
                ],
            ]);

            

            return redirect($response->url, 303);
        } catch (\Exception $e) {
            Log::error('Unable to create payment session: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to create payment session: ' . $e->getMessage()]);
        }
    }



    public function stripeCheckoutSuccess(Request $request)
    {
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $session = $stripe->checkout->sessions->retrieve($request->session_id);
            
            // Check if payment was successful
            if ($session->payment_status === 'paid') {
                // Get order item IDs from metadata
                $orderItemIds = explode(',', $session->metadata->order_item_ids);
                
                // Update order items payment status to success
                OrderItem::whereIn('id', $orderItemIds)
                    ->update([
                        'payment_status' => 1,
                    ]);
                // notify administrator that a user made a transaction
                $admins = Admin::all();
                if ($admins->isNotEmpty()) {
                    Notification::send($admins, new OrderNotification($orderItemIds, Auth::user()));
                }
                // Clear the user's cart after successful payment
                Cart::where('user_id', $session->metadata->user_id)->delete();
                $successMessage = "Payment successful! Your order has been confirmed.";
                
            } else {
                $successMessage = "Payment status: " . $session->payment_status;
                Log::warning('Payment not completed. Status: ' . $session->payment_status);
            }

            return view('frontend.success', compact('successMessage'));
            
        } catch (\Exception $e) {
            Log::error('Error processing payment success: ' . $e->getMessage());
            return redirect()->route('checkout')->with('error', 'Error processing payment confirmation.');
        }
    }

    public function stripeCheckoutCancel()
    {
        return redirect()->route('checkout')->with('error', 'Payment was cancelled.');
    }
}
