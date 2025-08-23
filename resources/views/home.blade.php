@extends('layouts.app')

@section('title', 'NexaMart - Discover Tomorrow\'s Technology Today')
@section('description', 'Explore cutting-edge products and futuristic technology at NexaMart. Your gateway to the future.')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Animated Background -->
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-gradient-to-r from-black via-purple-900/30 to-black"></div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-cyan-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl md:text-7xl font-orbitron font-black mb-6">
            <span class="bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent animate-pulse">
                NEXA MART
            </span>
            <br>
            <span class="text-white"></span>
        </h1>
        
        <p class="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed">
            Discover tomorrow's technology today. Experience cutting-edge products that redefine the boundaries of innovation.
        </p>
        
        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
            <a href="{{ route('products.index') }}" class="futuristic-btn text-lg px-8 py-4">
                Explore Products
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
            <a href="#categories" class="futuristic-btn-outline text-lg px-8 py-4">
                Browse Categories
            </a>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- Categories Section -->
<section id="categories" class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-orbitron font-bold mb-4">
                <span class="bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                    Categories
                </span>
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Explore our diverse range of futuristic product categories
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($categories as $category)
                <div class="group relative">
                    <div class="glass-card p-6 h-full transform group-hover:scale-105 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-purple-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        @if($category->image)
                            <div class="relative mb-6 h-48 overflow-hidden rounded-lg">
                                <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            </div>
                        @endif
                        
                        <h3 class="text-2xl font-orbitron font-bold mb-3 text-cyan-400">{{ $category->name }}</h3>
                        <p class="text-gray-300 mb-6">{{ $category->description }}</p>
                        
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="futuristic-btn w-full justify-center">
                            Explore {{ $category->name }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-orbitron font-bold mb-4">
                <span class="bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                    Featured Products
                </span>
            </h2>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Discover our handpicked selection of revolutionary products
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
                <div class="group relative">
                    <div class="glass-card p-6 h-full transform group-hover:scale-105 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-purple-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        
                        <div class="relative mb-4">
                            @if($product->images && count($product->images) > 0)
                                <div class="aspect-square overflow-hidden rounded-lg bg-gray-800">
                                    <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="aspect-square bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                          <!-- Wishlist Button -->
                            @auth
                                <button onclick="toggleWishlist({{ $product->id }})" class="absolute top-2 right-2 p-2 bg-black/50 rounded-full backdrop-blur-sm hover:bg-black/70 transition-colors">
                                    <svg class="w-5 h-5 {{ auth()->user()->wishlist->contains($product->id) ? 'text-red-500' : 'text-gray-400' }}" data-product-id="{{ $product->id }}" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                </button>
                            @endauth
                        </div>
                        
                        <div class="space-y-2">
                            <h3 class="text-lg font-semibold text-white group-hover:text-cyan-400 transition-colors">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-400">{{ $product->category->name }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    @if($product->isOnSale())
                                        <span class="text-lg font-bold text-cyan-400">${{ number_format($product->sale_price, 2) }}</span>
                                        <span class="text-sm text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                                    @else
                                        <span class="text-lg font-bold text-cyan-400">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                                <button onclick="addToCart({{ $product->id }})" class="p-2 bg-gradient-to-r from-cyan-500 to-purple-500 rounded-lg hover:from-cyan-400 hover:to-purple-400 transition-all transform hover:scale-105">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.1 5M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <a href="{{ route('products.show', $product) }}" class="absolute inset-0"></a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}" class="futuristic-btn-outline text-lg px-8 py-4">
                View All Products
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="glass-card p-8 md:p-12">
            <h2 class="text-3xl md:text-4xl font-orbitron font-bold mb-4">
                <span class="bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                    Stay Ahead of Tomorrow
                </span>
            </h2>
            <p class="text-xl text-gray-300 mb-8">
                Subscribe to our newsletter and be the first to know about groundbreaking products and exclusive offers.
            </p>
            
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input type="email" placeholder="Enter your email address" class="flex-1 px-4 py-3 bg-white/10 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/50">
                <button type="submit" class="futuristic-btn px-8 py-3 whitespace-nowrap">
                    Subscribe Now
                </button>
            </form>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endpush