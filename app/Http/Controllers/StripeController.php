<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
  use Stripe\Stripe;
  use Stripe\Checkout\Session;

class StripeController extends Controller
{
  public function index(Request $request)
   {
    return view('stripe.stripe', [
        'success'  => $request->query('success'),
        'canceled' => $request->query('canceled'),
    ]);
    }

     
     public function checkout(Request $request)
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
                    'payment_intent_data' => [
                           'description' => 'This is a test payment.',  ],     //  goes into the transaction      
                    'success_url' => url('/stripe/success-redirect'),
                    'cancel_url' => route('payment.cancel'),
                ]);
    
                return redirect($session->url, 303);
            } catch (\Exception $e) {
                return back()->withErrors(['error' => 'Unable to create payment session: ' . $e->getMessage()]);
            }
        }
}

