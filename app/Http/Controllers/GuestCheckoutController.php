<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Product;
use App\Models\Transaction;

class GuestCheckoutController extends Controller
{
    public function processCheckout(Request $request, int $productId)
    {
        $validated = $request->validate([
            'quantity' => 'integer|min:1',
            'selected_color' => 'nullable|string|max:255',
            'selected_size' => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($productId);

        Stripe::setApiKey(config('services.stripe.secret'));

        $shippingFee = 20.00;
        $shippingFeeInCents = $shippingFee * 100;

        $lineItems = [
            [
                'price_data' => [
                    'currency' => 'php',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $validated['quantity'],
            ],
            [
                'price_data' => [
                    'currency' => 'php',
                    'product_data' => [
                        'name' => 'Shipping Fee',
                    ],
                    'unit_amount' => $shippingFeeInCents,
                ],
                'quantity' => 1,
            ],
        ];

        $metadata = [
            'product_id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $validated['quantity'],
            'selected_color' => $validated['selected_color'] ?? '',
            'selected_size' => $validated['selected_size'] ?? '',
            'shipping_fee' => $shippingFee,
        ];

        try {
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('guest.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('guest.checkout.cancel') . '?session_id={CHECKOUT_SESSION_ID}',
                'metadata' => $metadata,
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating checkout session: ' . $e->getMessage());
        }
    }

    public function checkoutSuccess(Request $request)
    {
        $sessionId = $request->query('session_id');

        if (!$sessionId) {
            return redirect()->route('guest.dashboard')->withErrors('Session ID is missing!');
        }

        $stripe = new StripeClient(config('services.stripe.secret'));

        try {
            $session = $stripe->checkout->sessions->retrieve($sessionId);
            $paymentIntent = $stripe->paymentIntents->retrieve($session->payment_intent);

            if ($paymentIntent->status === 'succeeded') {
                $purchasedItem = json_decode($session->metadata, true);

                // $transaction = Transaction::create([
                //     'transaction_id' => $paymentIntent->id,
                //     'user_id' => "1",
                //     'amount_paid' => $paymentIntent->amount_received / 100,
                //     'payment_date' => now(),
                //     'delivery_date' => now()->addDays(5),
                //     'status' => 'completed',
                //     'purchased_items' => json_encode($purchasedItem),
                // ]);

                return view('guest.checkout.success', [
                    'transactionId' => $paymentIntent->id,
                    'amountPaid' => $paymentIntent->amount_received / 100,
                    'paymentDate' => now()->format('M d, Y'),
                    'deliveryDate' => now()->addDays(5)->format('M d, Y'),
                    'purchasedItem' => $purchasedItem,
                ]);
            }

            return redirect()->route('guest.dashboard')->with('error', 'Payment not verified.');
        } catch (\Exception $e) {
            return redirect()->route('guest.dashboard')->with('error', 'Unable to retrieve payment details: ' . $e->getMessage());
        }
    }

    public function checkoutCancel(Request $request)
    {
        $sessionId = $request->query('session_id');
        $attemptedAmount = null;

        if ($sessionId) {
            $stripe = new StripeClient(config('services.stripe.secret'));

            try {
                $session = $stripe->checkout->sessions->retrieve($sessionId);
                $attemptedAmount = $session->amount_total ?? 0;
            } catch (\Exception $e) {
                return redirect()->route('guest.dashboard')->withErrors('Unable to retrieve payment details: ' . $e->getMessage());
            }
        }

        $attemptedAmount = $attemptedAmount ? number_format($attemptedAmount / 100, 2) : '0.00';
        $cancellationReason = 'Payment not completed';

        return view('guest.checkout.cancel', compact('attemptedAmount', 'cancellationReason'));
    }
}
