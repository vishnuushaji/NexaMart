@extends('layouts.app')

@section('title', 'Products - NexaMart')
@section('description', 'Browse our collection of futuristic products and cutting-edge technology.')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-orbitron font-bold mb-4">
                <span class="bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                    Products
                </span>
            </h1>
            <p class="text-xl text-gray-300">Discover the future of technology</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filters Sidebar -->
            <div class="lg:w-1/4">
                <div class="glass-card p-6 sticky top-20">
                    <h3 class="text-xl font-orbitron font-bold mb-6 text-cyan-400">Filters</h3>
                    
                    <form method="GET" action="{{ route('products.index') }}" class="space-y-6">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Search</label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." 
                                class="w-full px-4 py-2 bg-white/10 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500">
                        </div>

                        <!-- Categories -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                            <select name="category" class="w-full px-4 py-2 bg-white/10 border border-cyan-500/30 rounded-lg text-white focus:outline-none focus:border-cyan-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Price Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" 
                                    class="px-3 py-2 bg-white/10 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500">
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" 
                                    class="px-3 py-2 bg-white/10 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500">
                            </div>
                        </div>

                        <!-- Sort -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Sort By</label>
                            <select name="sort" class="w-full px-4 py-2 bg-white/10 border border-cyan-500/30 rounded-lg text-white focus:outline-none focus:border-cyan-500">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                            </select>
                        </div>

                        <div class="flex space-x-2">
                            <button type="submit" class="futuristic-btn flex-1 justify-center">Apply</button>
                            <a href="{{ route('products.index') }}" class="futuristic-btn-outline flex-1 justify-center">Reset</a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-300">Showing {{ $products->count() }} of {{ $products->total() }} products</p>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                        @foreach($products as $product)
                            <div class="group relative">
                                <div class="glass-card p-6 h-full transform group-hover:scale-105 transition-all duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-br from-cyan-500/10 to-purple-500/10 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                    
                                    <div class="relative mb-4">
                                        @if($product->images && count($product->images) > 0)
                                            <div class="aspect-square overflow-hidden rounded-lg bg-gray-800">
                                                <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                            </div>
                                        @else
                                            <div class="aspect-square bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg flex items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        @if($product->isOnSale())
                                            <span class="absolute top-2 left-2 bg-gradient-to-r from-pink-500 to-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">SALE</span>
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
                                    
                                    <div class="space-y-3">
                                        <div>
                                            <h3 class="text-lg font-semibold text-white group-hover:text-cyan-400 transition-colors line-clamp-2">{{ $product->name }}</h3>
                                            <p class="text-sm text-gray-400">{{ $product->category->name }}</p>
                                        </div>
                                        
                                        @if($product->short_description)
                                            <p class="text-sm text-gray-300 line-clamp-2">{{ $product->short_description }}</p>
                                        @endif
                                        
                                        <div class="flex items-center justify-between pt-2">
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

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $products->withQueryString()->links('pagination::tailwind') }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="glass-card p-12 max-w-md mx-auto">
                            <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.44-1.01-5.879-2.614m11.758 0C15.44 14.99 13.34 16 12 16s-3.44-1.01-4.879-2.614M6 18a9 9 0 1112 0v.01"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-white mb-2">No products found</h3>
                            <p class="text-gray-400 mb-4">Try adjusting your filters or search terms</p>
                            <a href="{{ route('products.index') }}" class="futuristic-btn">Reset Filters</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection