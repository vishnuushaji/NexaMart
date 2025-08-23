@extends('layouts.app')

@section('title', 'Add New Product - Admin')

@section('content')
<div class="min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-cyan-400 hover:text-cyan-300 mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Products
            </a>
            <h1 class="text-4xl font-orbitron font-bold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                Add New Product
            </h1>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-black/40 backdrop-blur-md rounded-xl border border-cyan-500/30 p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div class="col-span-2">
                    <label for="name" class="block text-sm font-medium text-cyan-400 mb-2">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-cyan-400 mb-2">Category</label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-medium text-cyan-400 mb-2">SKU</label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                    @error('sku')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-cyan-400 mb-2">Price</label>
                    <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                    @error('price')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                                </div>

                <!-- Sale Price -->
                <div>
                    <label for="sale_price" class="block text-sm font-medium text-cyan-400 mb-2">Sale Price (Optional)</label>
                    <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                    @error('sale_price')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock Quantity -->
                <div>
                    <label for="stock_quantity" class="block text-sm font-medium text-cyan-400 mb-2">Stock Quantity</label>
                    <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                    @error('stock_quantity')
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

                <!-- Featured -->
                <div>
                    <label for="is_featured" class="block text-sm font-medium text-cyan-400 mb-2">Featured Product</label>
                    <select name="is_featured" id="is_featured" required
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">
                        <option value="0" {{ old('is_featured', 0) == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('is_featured') == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                    @error('is_featured')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="col-span-2">
                    <label for="description" class="block text-sm font-medium text-cyan-400 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" required
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Images -->
                <div class="col-span-2">
                    <label for="images" class="block text-sm font-medium text-cyan-400 mb-2">Product Images</label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-500/20 file:text-cyan-400 hover:file:bg-cyan-500/30">
                    <p class="mt-1 text-sm text-gray-400">Upload multiple images. Accepted formats: JPEG, PNG, JPG, WebP (Max: 2MB each)</p>
                    @error('images.*')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Preview -->
                <div class="col-span-2" id="image-preview-container" style="display: none;">
                    <label class="block text-sm font-medium text-cyan-400 mb-2">Image Preview</label>
                    <div id="image-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('admin.products.index') }}" class="px-6 py-3 bg-gray-600/50 hover:bg-gray-600/70 text-white rounded-lg transition-colors">
                    Cancel
                </a>
                <button type="submit" class="futuristic-btn">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image preview functionality
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('image-preview-container');
        preview.innerHTML = '';
        
        if (e.target.files.length > 0) {
            container.style.display = 'block';
            
            Array.from(e.target.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative group';
                        div.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" class="w-full h-32 object-cover rounded-lg">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                <p class="text-xs text-white">${file.name}</p>
                            </div>
                        `;
                        preview.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            });
        } else {
            container.style.display = 'none';
        }
    });

    // Auto-generate SKU from product name
    document.getElementById('name').addEventListener('input', function(e) {
        const sku = document.getElementById('sku');
        if (!sku.value || sku.value === '') {
            const name = e.target.value;
            const generatedSku = 'PRD-' + name.toUpperCase().replace(/[^A-Z0-9]/g, '').substring(0, 8) + '-' + Date.now().toString().slice(-4);
            sku.value = generatedSku;
        }
    });
</script>
@endpush