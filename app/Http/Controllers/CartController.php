<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function view()
    {
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        return view('cart.view', compact('cartItems'));
    }

    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $cartItem = Cart::where([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'color' => $request->selected_color,
            'size' => $request->selected_size,
        ])->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $request->quantity,
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => $request->quantity,
                'color' => $request->selected_color,
                'size' => $request->selected_size,
            ]);
        }

        return redirect()->route('cart.view', $productId)->with('success', 'Product added to cart!');
    }

    public function remove($cartItemId)
    {
        $cartItem = Cart::where('id', $cartItemId)->where('user_id', Auth::id())->firstOrFail();
        $cartItem->delete();

        return redirect()->route('cart.view')->with('success', 'Product removed from cart!');
    }
}
