<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'Futuristic Product Showcase - Discover the future of technology')">
<title>@yield('title', config('app.name', 'Laravel'))</title>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=orbitron:400,500,700,900|exo-2:300,400,500,600,700" rel="stylesheet" />

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>
</head>
<body class="bg-black text-white min-h-screen font-exo">
    <div class="relative min-h-screen bg-gradient-to-br from-black via-purple-900/20 to-black">
        <!-- Background Effects -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-1/2 -right-1/2 w-full h-full bg-gradient-to-br from-cyan-500/10 to-purple-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-1/2 -left-1/2 w-full h-full bg-gradient-to-tr from-pink-500/10 to-blue-500/10 rounded-full blur-3xl"></div>
        </div>
    <!-- Navigation -->
    <nav class="relative z-50 bg-black/20 backdrop-blur-md border-b border-cyan-500/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-orbitron font-bold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                        NexaMart
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                        <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">Products</a>
                        @auth
                            <a href="{{ route('wishlist.index') }}" class="nav-link {{ request()->routeIs('wishlist.*') ? 'active' : '' }}">Wishlist</a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">Admin</a>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Right Side -->
                <div class="hidden md:flex items-center space-x-4">
                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-cyan-400 hover:text-cyan-300 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6"></path>
                        </svg>
                        <span id="cart-count" class="absolute -top-1 -right-1 bg-gradient-to-r from-pink-500 to-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </a>

                    <!-- User Menu -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-cyan-400 hover:text-cyan-300">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-black/90 backdrop-blur-md rounded-lg border border-cyan-500/20 py-2">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-white hover:bg-cyan-500/20">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-white hover:bg-cyan-500/20">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="futuristic-btn">Login</a>
                        <a href="{{ route('register') }}" class="futuristic-btn-outline">Register</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button x-data @click="$dispatch('toggle-mobile-menu')" class="text-cyan-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open" class="md:hidden bg-black/90 backdrop-blur-md">
            <div class="px-2 pt-2 pb-3 space-y-1 border-t border-cyan-500/20">
                <a href="{{ route('home') }}" class="mobile-nav-link">Home</a>
                <a href="{{ route('products.index') }}" class="mobile-nav-link">Products</a>
                @auth
                    <a href="{{ route('wishlist.index') }}" class="mobile-nav-link">Wishlist</a>
                    <a href="{{ route('cart.index') }}" class="mobile-nav-link">Cart</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link">Admin</a>
                    @endif
                    <a href="{{ route('profile.edit') }}" class="mobile-nav-link">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mobile-nav-link w-full text-left">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mobile-nav-link">Login</a>
                    <a href="{{ route('register') }}" class="mobile-nav-link">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="relative z-10">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-500/20 border border-green-500/50 text-green-100 px-4 py-3 rounded-lg backdrop-blur-sm">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-500/20 border border-red-500/50 text-red-100 px-4 py-3 rounded-lg backdrop-blur-sm">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="relative z-10 bg-black/40 backdrop-blur-md border-t border-cyan-500/20 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="space-y-4">
                    <h3 class="text-xl font-orbitron font-bold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                        NexaMart
                    </h3>
                    <p class="text-gray-300">Discover the future of technology with our cutting-edge products.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-cyan-400 hover:text-cyan-300 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-cyan-400 hover:text-cyan-300 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-cyan-400 hover:text-cyan-300 transition-colors">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.348-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.163-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.986C24.007 5.367 18.641.001 12.017.001z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-cyan-400">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-300 hover:text-white transition-colors">Products</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Customer Service -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-cyan-400">Customer Service</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Shipping Info</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Returns</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="space-y-4">
                    <h4 class="text-lg font-semibold text-cyan-400">Stay Updated</h4>
                    <p class="text-gray-300">Subscribe to our newsletter for the latest updates.</p>
                    <form class="space-y-2">
                        <input type="email" placeholder="Enter your email" class="w-full px-4 py-2 bg-white/10 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500">
                        <button type="submit" class="w-full futuristic-btn">Subscribe</button>
                    </form>
                </div>
            </div>

            <div class="border-t border-cyan-500/20 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; 2024 NexaMart. All rights reserved. | Built with Laravel & Love</p>
            </div>
        </div>
    </footer>
</div>

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<script>
    // Update cart count on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateCartCount();
    });

    function updateCartCount() {
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                document.getElementById('cart-count').textContent = data.count || 0;
            })
            .catch(error => console.log('Error:', error));
    }

    // Add to cart function
    function addToCart(productId, quantity = 1) {
        fetch(`/cart/add/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartCount();
                // Show success message
                showNotification(data.message, 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error adding product to cart', 'error');
        });
    }

    // Toggle wishlist
    function toggleWishlist(productId) {
        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update heart icon
                const heartIcon = document.querySelector(`[data-product-id="${productId}"]`);
                if (heartIcon) {
                    heartIcon.classList.toggle('text-red-500');
                    heartIcon.classList.toggle('text-gray-400');
                }
                showNotification(data.message, 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Please login to add to wishlist', 'error');
        });
    }

    // Show notification
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-lg backdrop-blur-md border ${
            type === 'success' ? 'bg-green-500/20 border-green-500/50 text-green-100' :
            type === 'error' ? 'bg-red-500/20 border-red-500/50 text-red-100' :
            'bg-blue-500/20 border-blue-500/50 text-blue-100'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
</script>

@stack('scripts')
</body>
</html>