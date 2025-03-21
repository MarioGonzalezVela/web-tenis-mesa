<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{

    public function index()
    {
        $carts = Cart::all();
        return response()->json($carts, 200);
    }

    public function show($cartId)
    {
        $cart = Cart::with('cartItems.product')->findOrFail($cartId);
        return response()->json($cart, 200);
    }

    public function store(Request $request)
    {
        $cart = Cart::create([
            'customer_id' => $request->customer_id,
        ]);
        return response()->json($cart, 201);
    }

    public function addItem(Request $request, $cartId)
    {
        $cart = Cart::findOrFail($cartId);

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = $cart->cartItems()->create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json($cartItem, 201);
    }

    public function removeItem($cartId, $productId)
    {
        $cart = Cart::findOrFail($cartId);
        $cartItem = $cart->cartItems()->where('product_id', $productId)->firstOrFail();
        $cartItem->delete();

        return response()->json(['message' => 'Producto eliminado del carrito'], 200);
    }

    public function updateItem(Request $request, $cartId, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($cartId);
        $cartItem = $cart->cartItems()->where('product_id', $productId)->firstOrFail();
        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json($cartItem, 200);
    }
}
