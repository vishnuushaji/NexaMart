<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $product->getCurrentPrice() * $details['quantity']
                ];
                $total += $product->getCurrentPrice() * $details['quantity'];
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Check if product is active
            if (!$product->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is not available'
                ], 400);
            }
            
            // Check stock
            if (isset($product->stock_quantity) && $product->stock_quantity < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is out of stock'
                ], 400);
            }

            $cart = session()->get('cart', []);
            $quantity = $request->input('quantity', 1);

            // Check if product already exists in cart
            if (isset($cart[$product->id])) {
                // Check stock limit if stock_quantity exists
                if (isset($product->stock_quantity) && 
                    ($cart[$product->id]['quantity'] + $quantity) > $product->stock_quantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot add more items. Stock limit reached.'
                    ], 400);
                }
                
                $cart[$product->id]['quantity'] += $quantity;
            } else {
                $cart[$product->id] = [
                    'name' => $product->name,
                    'quantity' => $quantity,
                    'price' => $product->getCurrentPrice(),
                    'image' => $product->images[0] ?? null
                ];
            }

            session()->put('cart', $cart);

            // Calculate total items in cart
            $cartCount = 0;
            foreach ($cart as $item) {
                $cartCount += $item['quantity'];
            }

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cartCount' => $cartCount
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding product to cart'
            ], 500);
        }
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        $count = 0;
        
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        
        return response()->json(['count' => $count]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            // Check stock if needed
            $product = Product::find($id);
            if ($product && isset($product->stock_quantity) && 
                $request->quantity > $product->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough stock available'
                ], 400);
            }
            
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            
            // Calculate new total
            $cartCount = 0;
            foreach ($cart as $item) {
                $cartCount += $item['quantity'];
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cartCount' => $cartCount
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            
            // Calculate new total
            $cartCount = 0;
            foreach ($cart as $item) {
                $cartCount += $item['quantity'];
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cartCount' => $cartCount
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }
}