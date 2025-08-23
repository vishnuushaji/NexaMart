@extends('layouts.app')

@section('title', 'My Wishlist - NexaMart')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-orbitron font-bold text-white mb-2">My Wishlist</h1>
            <p class="text-gray-400">Save your favorite items for later</p>
        </div>

        @if($wishlistItems->count() > 0)
            <!-- Wishlist Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($wishlistItems as $product)
                    <div class="group relative bg-black/40 backdrop-blur-md rounded-xl border border-cyan-500/30 hover:border-cyan-500 transition-all duration-300 overflow-hidden" id="wishlist-item-{{ $product->id }}">
                        <!-- Product Image -->
                        <a href="{{ route('products.show', $product->id) }}" class="block">
                            <div class="relative aspect-square overflow-hidden">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ Storage::url($product->images[0]) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-800">
                                        <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif

                                <!-- Sale Badge -->
                                @if($product->sale_price)
                                    <div class="absolute top-2 left-2 px-3 py-1 bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold rounded-full">
                                        SALE {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                                    </div>
                                @endif

                                <!-- Remove from Wishlist Button -->
                                <button onclick="toggleWishlist({{ $product->id }})" 
                                        class="absolute top-2 right-2 p-2 bg-black/60 backdrop-blur-sm rounded-full hover:bg-red-500/80 transition-all duration-300 group/btn">
                                    <svg class="w-5 h-5 text-white group-hover/btn:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </a>

                        <!-- Product Info -->
                        <div class="p-4 space-y-3">
                            <h3 class="text-lg font-semibold text-white group-hover:text-cyan-400 transition-colors line-clamp-2">
                                <a href="{{ route('products.show', $product->id) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            @if($product->category)
                                <p class="text-sm text-gray-400">{{ $product->category->name }}</p>
                            @endif

                            <!-- Price -->
                            <div class="flex items-baseline space-x-2">
                                @if($product->sale_price)
                                    <span class="text-xl font-bold text-cyan-400">${{ number_format($product->sale_price, 2) }}</span>
                                    <span class="text-sm text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                                @else
                                    <span class="text-xl font-bold text-cyan-400">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>

                            <!-- Stock Status -->
                            <div class="text-sm">
                                @if($product->stock_quantity > 10)
                                    <span class="text-green-400">In Stock</span>
                                @elseif($product->stock_quantity > 0)
                                    <span class="text-yellow-400">Only {{ $product->stock_quantity }} left</span>
                                @else
                                    <span class="text-red-400">Out of Stock</span>
                                @endif
                            </div>

                            <!-- Add to Cart Button -->
                            @if($product->stock_quantity > 0)
                                <button onclick="addToCart({{ $product->id }})" 
                                        class="w-full py-2 px-4 bg-cyan-500/20 border border-cyan-500/30 rounded-lg hover:bg-cyan-500/30 transition-all duration-300 text-cyan-400 flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span>Add to Cart</span>
                                </button>
                            @else
                                <button disabled 
                                        class="w-full py-2 px-4 bg-gray-500/20 border border-gray-500/30 rounded-lg text-gray-400 cursor-not-allowed">
                                    Out of Stock
                                </button>
                            @endif

                            <!-- Added Date -->
                            <p class="text-xs text-gray-500 pt-2">
                                Added {{ $product->pivot->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($wishlistItems->hasPages())
                <div class="mt-12">
                    {{ $wishlistItems->links() }}
                </div>
            @endif
        @else
            <!-- Empty Wishlist -->
            <div class="text-center py-16">
                <div class="mb-8">
                    <svg class="w-24 h-24 mx-auto text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-4">Your wishlist is empty</h2>
                <p class="text-gray-400 mb-8">Start adding items you love to your wishlist!</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center futuristic-btn">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                    </svg>
                    Explore Products
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleWishlist(productId) {
        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Animate and remove the item
                const itemElement = document.getElementById(`wishlist-item-${productId}`);
                if (itemElement) {
                    itemElement.style.opacity = '0';
                    itemElement.style.transform = 'scale(0.8)';
                    setTimeout(() => {
                        itemElement.remove();
                        
                        // Check if wishlist is now empty
                        const remainingItems = document.querySelectorAll('[id^="wishlist-item-"]');
                        if (remainingItems.length === 0) {
                            window.location.reload();
                        }
                    }, 300);
                }
                
                showNotification(data.message || 'Item removed from wishlist', 'success');
            } else {
                showNotification(data.message || 'Error removing item', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error removing item from wishlist', 'error');
        });
    }

    function addToCart(productId) {
        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: 1 })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message || 'Product added to cart!', 'success');
                updateCartCount(data.cartCount);
            } else {
                showNotification(data.message || 'Failed to add product to cart', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error adding product to cart', 'error');
        });
    }

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg backdrop-blur-md border animate-slide-in ${
            type === 'success' ? 'bg-green-500/20 border-green-500/50 text-green-100' :
            type === 'error' ? 'bg-red-500/20 border-red-500/50 text-red-100' :
                        'bg-blue-500/20 border-blue-500/50 text-blue-100'
        }`;
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                ${type === 'success' ? 
                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
                    type === 'error' ?
                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>' :
                    '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                }
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('animate-fade-out');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    function updateCartCount(count) {
        document.querySelectorAll('.cart-count').forEach(element => {
            element.textContent = count;
        });
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
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Add smooth transitions for item removal */
    [id^="wishlist-item-"] {
        transition: all 0.3s ease-out;
    }
</style>
@endpush