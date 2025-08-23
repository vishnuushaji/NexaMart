@extends('layouts.app')

@section('title', 'Register - NexaMart')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <h2 class="text-4xl font-orbitron font-bold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                Join NexaMart
            </h2>
            <p class="mt-2 text-gray-400">Create your account and start shopping the future</p>
        </div>

        <!-- Registration Form -->
        <div class="bg-black/40 backdrop-blur-md rounded-2xl border border-cyan-500/30 p-8 shadow-2xl">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-cyan-400 mb-2">
                        Full Name
                    </label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/50 transition-all duration-300"
                        placeholder="Full Name">
                    @error('name')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-cyan-400 mb-2">
                        Email Address
                    </label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/50 transition-all duration-300"
                        placeholder="user@example.com">
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
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/50 transition-all duration-300"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-cyan-400 mb-2">
                        Confirm Password
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="w-full px-4 py-3 bg-black/50 border border-cyan-500/30 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:border-cyan-500 focus:ring-2 focus:ring-cyan-500/50 transition-all duration-300"
                        placeholder="••••••••">
                    @error('password_confirmation')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <input type="checkbox" name="terms" id="terms" required
                        class="mt-1 w-4 h-4 bg-black/50 border-cyan-500/30 rounded text-cyan-500 focus:ring-cyan-500">
                    <label for="terms" class="ml-2 text-sm text-gray-400">
                        I agree to the 
                        <a href="#" class="text-cyan-400 hover:text-cyan-300">Terms and Conditions</a> 
                        and 
                        <a href="#" class="text-cyan-400 hover:text-cyan-300">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full futuristic-btn">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Create Account
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

                <!-- Login Link -->
                <div class="text-center">
                    <span class="text-gray-400">Already have an account?</span>
                    <a href="{{ route('login') }}" 
                        class="ml-1 font-medium text-cyan-400 hover:text-cyan-300 transition-colors">
                        Sign in
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

@push('scripts')
<script>
    // Password strength indicator (optional)
    document.getElementById('password').addEventListener('input', function(e) {
        const password = e.target.value;
        const strength = checkPasswordStrength(password);
        // You can add a password strength indicator UI here
    });

    function checkPasswordStrength(password) {
        let strength = 0;
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]+/)) strength++;
        if (password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[$@#&!]+/)) strength++;
        return strength;
    }
</script>
@endpush