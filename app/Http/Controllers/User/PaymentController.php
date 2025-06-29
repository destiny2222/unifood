<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController extends Controller
{
   public function stripeCheckout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Laravel Stripe Payment',
                        ],
                        'unit_amount' => 1000, // $10.00 in cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel'),
            ]);

            return redirect($session->url, 303);
        } catch (\Exception $e) {
            Log::error('Unable to create payment session: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Unable to create payment session: ' . $e->getMessage()]);
        }
    }

     // public function stripe()
    // {
    //     $product = Config::get('stripe.product');
    //     return view('stripe', compact('product'));
    // }

    // public function stripeCheckout(Request $request)
    // {
    //     $stripe = new \Stripe\StripeClient(Config::get('stripe.stripe_secret_key'));

    //     $redirectUrl = route('stripe.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}';
    //     $response =  $stripe->checkout->sessions->create([
    //         'success_url' => $redirectUrl,
    //         'payment_method_types' => ['link', 'card'],
    //         'line_items' => [
    //             [
    //                 'price_data'  => [
    //                     'product_data' => [
    //                         'name' => $request->product,
    //                     ],
    //                     'unit_amount'  => 100 * $request->price,
    //                     'currency'     => 'USD',
    //                 ],
    //                 'quantity'    => 1
    //             ],
    //         ],
    //         'mode' => 'payment',
    //         'allow_promotion_codes' => false
    //     ]);

    //     return redirect($response['url']);
    // }

    // public function stripeCheckoutSuccess(Request $request)
    // {
    //     $stripe = new \Stripe\StripeClient(Config::get('stripe.stripe_secret_key'));

    //     $session = $stripe->checkout->sessions->retrieve($request->session_id);
    //     info($session);

    //     $successMessage = "We have received your payment request and will let you know shortly.";

    //     return view('success', compact('successMessage'));
    // }
}
