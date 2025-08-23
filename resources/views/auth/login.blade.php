@extends('layouts.app')

@section('title', 'Login - NexaMart')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <h2 class="text-4xl font-orbitron font-bold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                Welcome Back
            </h2>
            <p class="mt-2 text-gray-400">Sign in to your account to continue</p>
        </div>

        <!-- Login Form -->
        <div class="bg-black/40 backdrop-blur-md rounded-2xl border border-cyan-500/30 p-8 shadow-2xl">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
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

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-cyan-400 mb-2">
                        Password
                    </label>
                    <input id="password" name="password" type="password" required
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/50 transition-all duration-300">
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" 
                            class="w-4 h-4 bg-black/50 border-cyan-500/30 rounded text-cyan-500 focus:ring-cyan-500">
                        <span class="ml-2 text-sm text-gray-400">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                            class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full futuristic-btn">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Sign In
                </button>

                <!-- Divider -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-black text-gray-400">Or</span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <span class="text-gray-400">Don't have an account?</span>
                    <a href="{{ route('register') }}" 
                        class="ml-1 font-medium text-cyan-400 hover:text-cyan-300 transition-colors">
                        Sign up now
                    </a>
                </div>
            </form>
        </div>

        <!-- Decorative Elements -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-cyan-500/10 rounded-full blur-3xl"></div>
    </div>
</div>
@endsection