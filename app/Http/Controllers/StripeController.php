<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function checkout(Request $request)
    {
        $amount = $request->amount; // Example: 29

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],

            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',

                    'product_data' => [
                        'name' => 'Starter Plan',
                    ],

                    'unit_amount' => $amount * 100,
                ],

                'quantity' => 1,
            ]],

            'mode' => 'payment',

            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',

            'cancel_url' => route('payment.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $session = null;
        $customerEmail = auth()->check() ? auth()->user()->email : null;
        $amountPaid = null;
        $currency = 'USD';
        $paymentStatus = 'paid';

        if ($sessionId && config('services.stripe.secret')) {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                $session = Session::retrieve($sessionId);

                if ($session) {
                    $paymentStatus = $session->payment_status ?? 'paid';
                    $customerEmail = $session->customer_details->email ?? $customerEmail;
                    $amountPaid = isset($session->amount_total) ? ($session->amount_total / 100) : null;
                    $currency = strtoupper($session->currency ?? 'USD');

                    if ($paymentStatus === 'paid') {
                        $paymentIntent = $session->payment_intent;

                        // Store payment in database
                        // Create subscription
                        // Activate account
                    }
                }
            } catch (\Exception $e) {
                // Graceful fallback for test/dev sessions
            }
        }

        return view('payment.success', compact('sessionId', 'session', 'customerEmail', 'amountPaid', 'currency', 'paymentStatus'));
    }

    public function cancel()
    {
        return "Payment Cancelled";
    }
}
