<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $wishlistItems = auth()->user()->wishlist()->with('category')->paginate(12);
        return view('wishlist.index', compact('wishlistItems'));
    }

    public function toggle(Product $product)
    {
        $user = auth()->user();
        
        if ($user->wishlist()->where('product_id', $product->id)->exists()) {
            $user->wishlist()->detach($product->id);
            $message = 'Product removed from wishlist';
            $inWishlist = false;
        } else {
            $user->wishlist()->attach($product->id);
            $message = 'Product added to wishlist';
            $inWishlist = true;
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'inWishlist' => $inWishlist
        ]);
    }
}