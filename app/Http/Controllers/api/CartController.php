<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    // Listar todos los carritos)
    public function index()
    {
        return response()->json(Cart::all(), 200);
    }

    // Obtener carrito específico
    public function show($cartId)
    {
        $cart = Cart::with('cartItems.product')->findOrFail($cartId);
        return response()->json($cart, 200);
    }

    // Crear un nuevo carrito
    public function store(Request $request)
    {
        $cart = Cart::create([
            'customer_id' => $request->customer_id,
        ]);
        return response()->json($cart, 201);
    }

    // Añadir un producto al carrito
    public function addItem(Request $request, $cartId)
    {
        $cart = Cart::find($cartId);
        if (!$cart) {
            return response()->json(['error' => 'Carrito no encontrado'], 404);
        }

        $existingItem = $cart->cartItems()->where('product_id', $request->product_id)->first();

        if ($existingItem) {
            return response()->json(['error' => 'El producto ya está en el carrito. Usa el botón de + dentro del carrito.'], 400);
        } else {
            $cart->cartItems()->create([
                'product_id' => $request->product_id,
                'quantity' => 1
            ]);
        }

        return response()->json($cart->load('cartItems.product'));
    }


    // Eliminar un producto del carrito
    public function removeItem($cartId, $productId)
    {
        $cart = Cart::findOrFail($cartId);

        $cartItem = $cart->cartItems()->where('product_id', $productId)->firstOrFail();
        $cartItem->delete();

        return response()->json(['message' => 'Producto eliminado del carrito'], 200);
    }

    // Actualizar cantidad de un producto en el carrito
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
