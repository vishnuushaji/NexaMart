@extends('layouts.app')

@section('title', 'Add New Category - Admin')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center text-cyan-400 hover:text-cyan-300 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </a>
            <h1 class="text-4xl font-orbitron font-bold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                Add New Category
            </h1>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-black/40 backdrop-blur-md rounded-xl border border-cyan-500/30 p-8">
            @csrf

            <div class="space-y-6">
                <!-- Category Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-cyan-400 mb-2">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-cyan-400 mb-2">Description (Optional)</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-cyan-400 mb-2">Sort Order (Optional)</label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                    <p class="mt-1 text-sm text-gray-400">Lower numbers appear first</p>
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="is_active" class="block text-sm font-medium text-cyan-400 mb-2">Status</label>
                    <select name="is_active" id="is_active" required
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('admin.categories.index') }}" class="px-6 py-3 bg-gray-600/50 hover:bg-gray-600/70 text-white rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="futuristic-btn">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection