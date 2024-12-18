<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Checkout\Session;
use App\Models\Transaction;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $cartItems = auth()->user()->cartItems;

        $purchasedItems = $cartItems->map(function ($item) {
            return [
                'product_id' => $item->product->id,
                'name' => $item->product->name,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'color' => $item->color,
                'size' => $item->size,
            ];
        })->toArray();

        $shippingOption = $request->input('shipping_option', 'standard');

        $shippingOptions = [
            'standard' => ['fee' => 20.00],
            'express' => ['fee' => 55.00],
        ];

        if (!isset($shippingOptions[$shippingOption])) {
            return back()->withErrors(['error' => 'Invalid shipping option selected.']);
        }

        $shippingFee = $shippingOptions[$shippingOption]['fee'];
        $shippingFeeInCents = $shippingFee * 100;

        $lineItems = $cartItems->map(function ($item) {
            return [
                'price_data' => [
                    'currency' => 'php',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => $item->product->price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        })->toArray();

        $lineItems[] = [
            'price_data' => [
                'currency' => 'php',
                'product_data' => [
                    'name' => ucfirst($shippingOption) . ' Shipping',
                ],
                'unit_amount' => $shippingFeeInCents,
            ],
            'quantity' => 1,
        ];

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel') . '?session_id={CHECKOUT_SESSION_ID}',
            'metadata' => [
                'user_id' => auth()->id(),
                'cart_items' => json_encode($purchasedItems),
                'shipping_option' => $shippingOption,
                'shipping_fee' => $shippingFee,
            ],
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('dashboard')->withErrors('Session ID missing!');
        }

        $stripe = new StripeClient(config('services.stripe.secret'));

        try {
            $session = $stripe->checkout->sessions->retrieve($sessionId);
            $paymentIntent = $stripe->paymentIntents->retrieve($session->payment_intent);

            $transactionId = $paymentIntent->id;
            $shippingFee = $session->metadata['shipping_fee'];
            $amountPaid = $paymentIntent->amount_received / 100;
            $paymentDate = now()->format('M d, Y');

            $shippingOption = $session->metadata['shipping_option'];
            $deliveryDays = $shippingOption === 'express' ? 2 : 5;
            $deliveryDate = now()->addDays($deliveryDays)->format('M d, Y');

            $purchasedItems = json_decode($session->metadata['cart_items'], true);

            Transaction::create([
                'user_id' => auth()->id(),
                'transaction_id' => $transactionId,
                'amount_paid' => $amountPaid,
                'purchased_items' => $purchasedItems,
                'payment_date' => now(),
                'delivery_date' => now()->addDays($deliveryDays),
            ]);

            foreach ($purchasedItems as $item) {
                $product = \App\Models\Product::find($item['product_id']);

                if ($product) {
                    $product->stock -= $item['quantity'];
                    $product->sold += $item['quantity'];
                    $product->save();
                }
            }

            $user = auth()->user();
            $user->cartItems()->delete();

            return view('checkout.success', compact(
                'transactionId',
                'amountPaid',
                'paymentDate',
                'deliveryDate',
                'purchasedItems',
                'shippingFee'
            ));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Unable to retrieve payment details: ' . $e->getMessage());
        }
    }

    public function cancel(Request $request)
    {
        $sessionId = $request->query('session_id');
        $transactionId = null;
        $attemptedAmount = null;

        if ($sessionId) {
            $stripe = new StripeClient(config('services.stripe.secret'));

            try {
                $session = $stripe->checkout->sessions->retrieve($sessionId);
                $attemptedAmount = $session->amount_total ?? 0;
            } catch (\Exception $e) {
                return redirect()->route('dashboard')->withErrors('Unable to retrieve payment details: ' . $e->getMessage());
            }
        }

        $attemptedAmount = $attemptedAmount ? number_format($attemptedAmount / 100, 2) : '0.00';
        $cancellationReason = 'Payment not completed';

        return view('checkout.cancel', compact('attemptedAmount', 'cancellationReason'));
    }
}
