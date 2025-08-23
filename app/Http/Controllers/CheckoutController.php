<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $product->getCurrentPrice() * $details['quantity']
                ];
                $subtotal += $product->getCurrentPrice() * $details['quantity'];
            }
        }

        $tax = $subtotal * 0.08; // 8% tax
        $shipping = 10.00; // Flat shipping rate
        $total = $subtotal + $tax + $shipping;

        return view('checkout.index', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'billing_name' => 'required|string|max:255',
            'billing_email' => 'required|email',
            'billing_address' => 'required|string',
            'billing_city' => 'required|string',
            'billing_state' => 'required|string',
            'billing_zip' => 'required|string',
            'payment_method_id' => 'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        $subtotal = 0;
        foreach ($cart as $id => $details) {
            $product = Product::find($id);
            if ($product) {
                $subtotal += $product->getCurrentPrice() * $details['quantity'];
            }
        }

        $tax = $subtotal * 0.08;
        $shipping = 10.00;
        $total = $subtotal + $tax + $shipping;

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $total * 100, // Amount in cents
                'currency' => 'usd',
                'payment_method' => $request->payment_method_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                'return_url' => route('checkout.success'),
            ]);

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shipping,
                'total' => $total,
                'billing_address' => [
                    'name' => $request->billing_name,
                    'email' => $request->billing_email,
                    'address' => $request->billing_address,
                    'city' => $request->billing_city,
                    'state' => $request->billing_state,
                    'zip' => $request->billing_zip,
                ],
                'shipping_address' => [
                    'name' => $request->billing_name,
                    'address' => $request->billing_address,
                    'city' => $request->billing_city,
                    'state' => $request->billing_state,
                    'zip' => $request->billing_zip,
                ],
                'payment_method' => 'stripe',
                'payment_status' => 'completed',
                'stripe_payment_id' => $paymentIntent->id,
            ]);

            // Create order items
            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                if ($product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $details['quantity'],
                        'price' => $product->getCurrentPrice(),
                        'total' => $product->getCurrentPrice() * $details['quantity'],
                    ]);

                    // Update stock
                    $product->decrement('stock_quantity', $details['quantity']);
                }
            }

            // Clear cart
            session()->forget('cart');

            return response()->json([
                'success' => true,
                'redirect' => route('checkout.success', $order->id)
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(404);
        }

        return view('checkout.success', compact('order'));
    }
}