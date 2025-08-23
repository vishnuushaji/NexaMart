@extends('layouts.app')

@section('title', 'Manage Categories - Admin')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-orbitron font-bold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                Manage Categories
            </h1>
            <a href="{{ route('admin.categories.create') }}" class="futuristic-btn">
                <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Category
            </a>
        </div>

        <!-- Categories Table -->
        <div class="bg-black/40 backdrop-blur-md rounded-xl border border-cyan-500/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-black/60 border-b border-cyan-500/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-cyan-400 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-cyan-400 uppercase tracking-wider">Slug</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-cyan-400 uppercase tracking-wider">Products</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-cyan-400 uppercase tracking-wider">Sort Order</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-cyan-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-cyan-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse($categories as $category)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-white">{{ $category->name }}</div>
                                    @if($category->description)
                                        <div class="text-sm text-gray-400">{{ Str::limit($category->description, 50) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-300">{{ $category->slug }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-cyan-400">{{ $category->products_count }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-300">{{ $category->sort_order ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->is_active ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-yellow-400 hover:text-yellow-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure? This category has {{ $category->products_count }} products.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 {{ $category->products_count > 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19