<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    // Listar todos los carritos
    public function index()
    {
        $carts = Cart::all();
        return response()->json($carts, 200);
    }

    // Ver el carrito de un usuario
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
        $cart = Cart::findOrFail($cartId);

        // Validaciones de la solicitud
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Validamos si el carrito pertenece al usuario autenticado
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        // Validamos si el usuario tiene un cliente asociado
        if (!$user->customer) {
            return response()->json(['message' => 'El usuario no tiene un cliente asociado'], 400);
        }

        $customerId = $user->customer->id;
        if ($cart->customer_id !== $user->customer->id) {
            return response()->json(['message' => 'Acción no autorizada'], 403);
        }

        // Añadir el producto al carrito
        $cartItem = $cart->cartItems()->create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json($cartItem, 201);
    }

    // Eliminar un producto del carrito
    public function removeItem($cartId, $productId)
    {
        $cart = Cart::findOrFail($cartId);

        // Validamos si el carrito pertenece al usuario autenticado
        $user = request()->user();
        if ($cart->customer_id !== $user->id) {
            return response()->json(['message' => 'Acción no autorizada'], 403);
        }

        // Buscar el item y eliminarlo
        $cartItem = $cart->cartItems()->where('product_id', $productId)->firstOrFail();
        $cartItem->delete();

        return response()->json(['message' => 'Producto eliminado del carrito'], 200);
    }

    // Actualizar la cantidad de un producto en el carrito
    public function updateItem(Request $request, $cartId, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::findOrFail($cartId);

        // Validamos si el carrito pertenece al usuario autenticado
        $user = request()->user();
        if ($cart->customer_id !== $user->id) {
            return response()->json(['message' => 'Acción no autorizada'], 403);
        }

        // Buscar el item y actualizar la cantidad
        $cartItem = $cart->cartItems()->where('product_id', $productId)->firstOrFail();
        $cartItem->update(['quantity' => $request->quantity]);

        return response()->json($cartItem, 200);
    }

    public function getUserCart(Request $request)
    {
        $user = $request->user();

        // Si no hay usuario autenticado
        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        // Crear o devolver el carrito del usuario
        $cart = Cart::firstOrCreate(
            ['customer_id' => $user->id],
            ['customer_id' => $user->id]
        );

        return response()->json($cart, 200);
    }
}
