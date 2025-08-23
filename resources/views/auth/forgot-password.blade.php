@extends('layouts.app')

@section('title', 'Forgot Password - NexaMart')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-4xl font-orbitron font-bold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                Reset Password
            </h2>
            <p class="mt-2 text-gray-400">
                Forgot your password? No problem. Just enter your email and we’ll send you a reset link.
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-black/40 backdrop-blur-md rounded-2xl border border-cyan-500/30 p-8 shadow-2xl">
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-sm text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-cyan-400 mb-2">
                        Email Address
                    </label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/50 transition-all duration-300">
                    @error('email')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button type="submit" class="w-full futuristic-btn">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12H8m0 0l4-4m-4 4l4 4" />
                    </svg>
                    Email Password Reset Link
                </button>

                <!-- Back to login -->
                <div class="text-center">
                    <a href="{{ route('login') }}" 
                        class="mt-4 inline-block text-sm text-cyan-400 hover:text-cyan-300 transition-colors">
                        ← Back to Login
                    </a>
                </div>
            </form>
        </div>

        <!-- Decorative Blobs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl hidden sm:block"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-cyan-500/10 rounded-full blur-3xl hidden sm:block"></div>
    </div>
</div>
@endsection
