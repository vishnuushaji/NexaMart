@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-orbitron font-bold text-white mb-8">Admin Dashboard</h1>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Products -->
            <div class="bg-black/40 backdrop-blur-md rounded-xl border border-cyan-500/30 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Products</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['total_products'] ?? 0 }}</p>
                    </div>
                    <svg class="w-12 h-12 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-black/40 backdrop-blur-md rounded-xl border border-green-500/30 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Orders</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['total_orders'] ?? 0 }}</p>
                    </div>
                    <svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="bg-black/40 backdrop-blur-md rounded-xl border border-purple-500/30 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Customers</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['total_customers'] ?? 0 }}</p>
                    </div>
                    <svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Total Categories -->
            <div class="bg-black/40 backdrop-blur-md rounded-xl border border-yellow-500/30 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm">Total Categories</p>
                        <p class="text-3xl font-bold text-white mt-2">{{ $stats['total_categories'] ?? 0 }}</p>
                    </div>
                    <svg class="w-12 h-12 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('admin.products.create') }}" class="bg-black/40 backdrop-blur-md rounded-xl border border-cyan-500/30 p-6 hover:border-cyan-500 transition-all duration-300 group">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-cyan-500/20 rounded-lg group-hover:bg-cyan-500/30 transition-colors">
                        <svg class="w-8 h-8 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Add New Product</h3>
                        <p class="text-gray-400 text-sm">Create a new product listing</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.categories.create') }}" class="bg-black/40 backdrop-blur-md rounded-xl border border-green-500/30 p-6 hover:border-green-500 transition-all duration-300 group">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-green-500/20 rounded-lg group-hover:bg-green-500/30 transition-colors">
                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Add New Category</h3>
                        <p class="text-gray-400 text-sm">Create product categories</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.products.index') }}" class="bg-black/40 backdrop-blur-md rounded-xl border border-purple-500/30 p-6 hover:border-purple-500 transition-all duration-300 group">
                <div class="flex items-center space-x-4">
                    <div class="p-3 bg-purple-500/20 rounded-lg group-hover:bg-purple-500/30 transition-colors">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-white">Manage Products</h3>
                        <p class="text-gray-400 text-sm">View and edit all products</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Low Stock Alert -->
        @if(isset($stats['low_stock_products']) && $stats['low_stock_products']->count() > 0)
            <div class="mt-8 bg-red-500/10 backdrop-blur-md rounded-xl border border-red-500/30 p-6">
                <h3 class="text-xl font-semibold text-white mb-4 flex items-center">
                    <svg class="w-6 h-6 text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Low Stock Alert
                </h3>
                <div class="space-y-2">
                    @foreach($stats['low_stock_products'] as $product)
                        <div class="flex items-center justify-between p-3 bg-black/40 rounded-lg">
                            <span class="text-white">{{ $product->name }}</span>
                            <span class="text-red-400 font-semibold">{{ $product->stock_quantity }} left</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection