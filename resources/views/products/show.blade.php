@extends('layouts.app')

@section('title', $product->name . ' - NexaMart')
@section('description', Str::limit($product->description, 160))

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                <li class="text-gray-600">/</li>
                <li><a href="{{ route('products.index') }}" class="text-gray-400 hover:text-white transition-colors">Products</a></li>
                <li class="text-gray-600">/</li>
                <li class="text-cyan-400">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Product Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Product Images -->
            <div class="space-y-4">
                <div class="relative group overflow-hidden rounded-2xl bg-black/40 backdrop-blur-md border border-cyan-500/30">
                    @if($product->images && count($product->images) > 0)
                        <img id="main-image" src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}" 
                            class="w-full h-[500px] object-cover transition-transform duration-300 group-hover:scale-105">
                    @else
                        <div class="w-full h-[500px] flex items-center justify-center bg-gray-800">
                            <svg class="w-32 h-32 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Sale Badge -->
                    @if($product->sale_price)
                        <div class="absolute top-4 left-4 px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white text-sm font-bold rounded-full">
                            SALE {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                        </div>
                    @endif

                    <!-- Stock Badge -->
                    <div class="absolute top-4 right-4">
                        @if($product->stock_quantity > 10)
                            <span class="px-3 py-1 bg-green-500/20 text-green-400 text-sm rounded-full border border-green-500/30">
                                In Stock
                            </span>
                        @elseif($product->stock_quantity > 0)
                            <span class="px-3 py-1 bg-yellow-500/20 text-yellow-400 text-sm rounded-full border border-yellow-500/30">
                                Only {{ $product->stock_quantity }} left
                            </span>
                        @else
                            <span class="px-3 py-1 bg-red-500/20 text-red-400 text-sm rounded-full border border-red-500/30">
                                Out of Stock
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Thumbnail Images -->
                @if($product->images && count($product->images) > 1)
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $index => $image)
                            <button onclick="changeImage('{{ Storage::url($image) }}')" 
                                class="relative overflow-hidden rounded-lg bg-black/40 backdrop-blur-md border-2 border-cyan-500/30 hover:border-cyan-500 transition-colors">
                                <img src="{{ Storage::url($image) }}" alt="Thumbnail {{ $index + 1 }}" 
                                    class="w-full h-24 object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <!-- Category -->
                @if($product->category)
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" 
                        class="inline-block text-cyan-400 hover:text-cyan-300 text-sm transition-colors">
                        {{ $product->category->name }}
                    </a>
                @endif

                <!-- Title -->
                <h1 class="text-4xl font-orbitron font-bold text-white">{{ $product->name }}</h1>

                <!-- Price -->
                <div class="flex items-baseline space-x-4">
                    @if($product->sale_price)
                        <span class="text-3xl font-bold text-cyan-400">${{ number_format($product->sale_price, 2) }}</span>
                        <span class="text-xl text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                    @else
                        <span class="text-3xl font-bold text-cyan-400">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <!-- Description -->
                <div class="prose prose-invert max-w-none">
                    <p class="text-gray-300 leading-relaxed">{{ $product->description }}</p>
                </div>

                <!-- Product Details -->
                <div class="bg-black/40 backdrop-blur-md rounded-lg  border-cyan-500/30 p-6 space-y-3">
                    <h3 class="text-lg font-semibold text-cyan-400 mb-3">Product Details</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-400">SKU:</span>
                            <span class="text-white ml-2">{{ $product->sku }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400">Category:</span>
                            <span class="text-white ml-2">{{ $product->category->name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-400">Availability:</span>
                            <span class="text-white ml-2">
                                @if($product->stock_quantity > 0)
                                    {{ $product->stock_quantity }} in stock
                                @else
                                    Out of stock
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-gray-400">Condition:</span>
                            <span class="text-white ml-2">New</span>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart Section -->
                <div class="space-y-4">
                    @if($product->stock_quantity > 0)
                        <div class="flex items-center space-x-4">
                            <label for="quantity" class="text-gray-400">Quantity:</label>
                            <div class="flex items-center">
                                <button onclick="decreaseQuantity()" class="px-3 py-1 bg-black/40 border border-cyan-500/30 rounded-l-lg hover:bg-white/10 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" 
                                    class="w-16 px-3 py-1 bg-black/40 border-t border-b border-cyan-500/30 text-center text-white focus:outline-none">
                                <button onclick="increaseQuantity()" class="px-3 py-1 bg-black/40 border border-cyan-500/30 rounded-r-lg hover:bg-white/10 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="flex space-x-4">
                            <button onclick="addToCart({{ $product->id }})" class="flex-1 futuristic-btn">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Add to Cart
                            </button>
                            
                            @auth
                                <button onclick="toggleWishlist({{ $product->id }})" 
                                    class="px-6 py-3 bg-black/40 border border-pink-500/30 rounded-lg hover:bg-pink-500/20 transition-all duration-300 group"
                                    data-product-id="{{ $product->id }}">
                                    <svg class="w-6 h-6 {{ auth()->user()->wishlist->contains($product->id) ? 'text-red-500' : 'text-gray-400' }} group-hover:text-red-500 transition-colors" 
                                        fill="{{ auth()->user()->wishlist->contains($product->id) ? 'currentColor' : 'none' }}" 
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            @endauth
                        </div>
                    @else
                        <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-4 text-center">
                            <p class="text-red-400">This product is currently out of stock</p>
                        </div>
                    @endif
                </div>

                <!-- Share -->
                <div class="flex items-center space-x-4 pt-6 border-t border-gray-700">
                    <span class="text-gray-400">Share:</span>
                    <button class="text-cyan-400 hover:text-cyan-300 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                        </svg>
                    </button>
                    <button class="text-cyan-400 hover:text-cyan-300 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                    </button>
                    <button class="text-cyan-400 hover:text-cyan-300 transition-colors">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-orbitron font-bold text-white mb-8">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="group relative bg-black/40 backdrop-blur-md rounded-xl border border-cyan-500/30 hover:border-cyan-500 transition-all duration-300 overflow-hidden">
                            <a href="{{ route('products.show', $relatedProduct) }}" class="block">
                                <div class="aspect-w-1 aspect-h-1 overflow-hidden">
                                    @if($relatedProduct->images && count($relatedProduct->images) > 0)
                                        <img src="{{ Storage::url($relatedProduct->images[0]) }}" alt="{{ $relatedProduct->name }}" 
                                            class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-64 flex items-center justify-center bg-gray-800">
                                            <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold text-white group-hover:text-cyan-400 transition-colors">{{ $relatedProduct->name }}</h3>
                                    <div class="mt-2 flex items-baseline space-x-2">
                                        @if($relatedProduct->sale_price)
                                            <span class="text-lg font-bold text-cyan-400">${{ number_format($relatedProduct->sale_price, 2) }}</span>
                                            <span class="text-sm text-gray-500 line-through">${{ number_format($relatedProduct->price, 2) }}</span>
                                        @else
                                            <span class="text-lg font-bold text-cyan-400">${{ number_format($relatedProduct->price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function changeImage(imageUrl) {
        document.getElementById('main-image').src = imageUrl;
    }

    function increaseQuantity() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        const current = parseInt(input.value);
        if (current < max) {
            input.value = current + 1;
        }
    }

    function decreaseQuantity() {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value);
        if (current > 1) {
            input.value = current - 1;
        }
    }

function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;
    
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: JSON.stringify({ quantity: parseInt(quantity) })
    })
    .then(response => {
        if (!response.ok) {
            throw response;
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification(data.message || 'Product added to cart!', 'success');
            // Update cart count in header if you have one
            updateCartCount(data.cartCount);
        } else {
            showNotification(data.message || 'Failed to add product to cart', 'error');
        }
    })
    .catch(error => {
        if (error.json) {
            error.json().then(errData => {
                showNotification(errData.message || 'Error adding product to cart', 'error');
            });
        } else {
            console.error('Error:', error);
            showNotification('Error adding product to cart', 'error');
        }
    });
}

function updateCartCount(count) {
    // Update all elements that show cart count
    document.querySelectorAll('.cart-count').forEach(element => {
        element.textContent = count;
    });
}

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg backdrop-blur-md border animate-slide-in ${
            type === 'success' ? 'bg-green-500/20 border-green-500/50 text-green-100' :
            type === 'error' ? 'bg-red-500/20 border-red-500/50 text-red-100' :
            'bg-blue-500/20 border-blue-500/50 text-blue-100'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('animate-fade-out');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
</script>

<style>
    @keyframes slide-in {
        from {
            transform: translateX(100%);
             opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes fade-out {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }
    
    .animate-fade-out {
        animation: fade-out 0.3s ease-out;
    }
</style>
@endpush