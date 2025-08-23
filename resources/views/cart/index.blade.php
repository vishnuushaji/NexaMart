@extends('layouts.app')

@section('title', 'Shopping Cart - NexaMart')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-orbitron font-bold text-white mb-2">Shopping Cart</h1>
            <p class="text-gray-400">Review your items before checkout</p>
        </div>

        @if(count($cartItems) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-black/40 backdrop-blur-md rounded-xl border border-cyan-500/30 p-6 hover:border-cyan-500/50 transition-all duration-300" id="cart-item-{{ $item['product']->id }}">
                            <div class="flex flex-col sm:flex-row gap-6">
                                <!-- Product Image -->
                                <div class="w-full sm:w-32 h-32 flex-shrink-0">
                                    @if($item['product']->images && count($item['product']->images) > 0)
                                        <img src="{{ Storage::url($item['product']->images[0]) }}" 
                                             alt="{{ $item['product']->name }}" 
                                             class="w-full h-full object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-full bg-gray-800 rounded-lg flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1 space-y-2">
                                    <h3 class="text-xl font-semibold text-white hover:text-cyan-400 transition-colors">
                                        <a href="{{ route('products.show', $item['product']->id) }}">
                                            {{ $item['product']->name }}
                                        </a>
                                    </h3>
                                    
                                    @if($item['product']->category)
                                        <p class="text-sm text-gray-400">{{ $item['product']->category->name }}</p>
                                    @endif

                                    <div class="flex items-center justify-between mt-4">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center space-x-2">
                                            <button onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] - 1 }})" 
                                                    class="p-1 bg-black/40 border border-cyan-500/30 rounded hover:bg-white/10 transition-colors"
                                                    {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            
                                            <span class="px-4 py-1 bg-black/40 border border-cyan-500/30 rounded text-white min-w-[50px] text-center">
                                                {{ $item['quantity'] }}
                                            </span>
                                            
                                            <button onclick="updateQuantity({{ $item['product']->id }}, {{ $item['quantity'] + 1 }})" 
                                                    class="p-1 bg-black/40 border border-cyan-500/30 rounded hover:bg-white/10 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Price -->
                                        <div class="text-right">
                                            <p class="text-sm text-gray-400">Price per item</p>
                                            <p class="text-lg font-semibold text-cyan-400">
                                                ${{ number_format($item['product']->getCurrentPrice(), 2) }}
                                            </p>
                                        </div>
                                    </div>

                                                                        <div class="flex items-center justify-between pt-4 border-t border-gray-700">
                                        <!-- Remove Button -->
                                        <button onclick="removeFromCart({{ $item['product']->id }})" 
                                                class="text-red-400 hover:text-red-300 text-sm flex items-center space-x-1 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            <span>Remove</span>
                                        </button>

                                        <!-- Subtotal -->
                                        <div>
                                            <p class="text-sm text-gray-400">Subtotal</p>
                                            <p class="text-xl font-bold text-white">
                                                ${{ number_format($item['subtotal'], 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-black/40 backdrop-blur-md rounded-xl border border-cyan-500/30 p-6 sticky top-24">
                        <h2 class="text-2xl font-orbitron font-bold text-white mb-6">Order Summary</h2>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-300">
                                <span>Subtotal</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-300">
                                <span>Shipping</span>
                                <span class="text-green-400">Free</span>
                            </div>
                            <div class="flex justify-between text-gray-300">
                                <span>Tax</span>
                                <span>${{ number_format($total * 0.08, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-700 pt-4">
                                <div class="flex justify-between text-xl font-bold text-white">
                                    <span>Total</span>
                                    <span class="text-cyan-400">${{ number_format($total * 1.08, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        @auth
                            <a href="{{ route('checkout.index') }}" class="w-full futuristic-btn mb-4">
                                Proceed to Checkout
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="w-full futuristic-btn mb-4">
                                Login to Checkout
                            </a>
                        @endauth
                        
                        <a href="{{ route('products.index') }}" 
                           class="w-full block text-center py-3 bg-black/40 border border-gray-600 rounded-lg hover:bg-white/10 transition-all duration-300 text-gray-300">
                            Continue Shopping
                        </a>

                        <!-- Promo Code Section -->
                        <div class="mt-6 pt-6 border-t border-gray-700">
                            <h3 class="text-sm font-semibold text-gray-400 mb-3">Have a promo code?</h3>
                            <div class="flex space-x-2">
                                <input type="text" 
                                       placeholder="Enter code" 
                                       class="flex-1 px-3 py-2 bg-black/40 border border-cyan-500/30 rounded-lg text-white placeholder-gray-500 focus:border-cyan-500 focus:outline-none">
                                <button class="px-4 py-2 bg-cyan-500/20 border border-cyan-500/30 rounded-lg hover:bg-cyan-500/30 transition-colors text-cyan-400">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
                     <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="mb-8">
                    <svg class="w-24 h-24 mx-auto text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-white mb-4">Your cart is empty</h2>
                <p class="text-gray-400 mb-8">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center futuristic-btn">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                    </svg>
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateQuantity(productId, newQuantity) {
        if (newQuantity < 1) return;
        
        fetch(`/cart/update/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ quantity: newQuantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to update totals
                window.location.reload();
            } else {
                showNotification(data.message || 'Error updating cart', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating cart', 'error');
        });
    }

    function removeFromCart(productId) {
        if (!confirm('Are you sure you want to remove this item?')) return;
        
        fetch(`/cart/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the item from DOM
                const itemElement = document.getElementById(`cart-item-${productId}`);
                if (itemElement) {
                    itemElement.style.opacity = '0';
                    itemElement.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        window.location.reload();
                    }, 300);
                }
                
                showNotification(data.message || 'Item removed from cart', 'success');
                updateCartCount(data.cartCount);
            } else {
                showNotification(data.message || 'Error removing item', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error removing item from cart', 'error');
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
        // Update all elements that show cart count
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
    
    /* Custom scrollbar for cart items */
    .cart-items-container::-webkit-scrollbar {
        width: 8px;
    }
    
    .cart-items-container::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 4px;
    }
    
    .cart-items-container::-webkit-scrollbar-thumb {
        background: rgba(6, 182, 212, 0.5);
        border-radius: 4px;
    }
    
    .cart-items-container::-webkit-scrollbar-thumb:hover {
        background: rgba(6, 182, 212, 0.7);
    }
</style>
@endpush