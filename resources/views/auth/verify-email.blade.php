@extends('layouts.app')

@section('title', 'Verify Email - NexaMart')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">

        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-4xl font-orbitron font-bold bg-gradient-to-r from-cyan-400 to-purple-400 bg-clip-text text-transparent">
                Verify Your Email
            </h2>
            <p class="mt-2 text-gray-400">
                Thanks for signing up! Before getting started, please check your email for a verification link.
                Didn’t receive it? You can request another one below.
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-black/40 backdrop-blur-md rounded-2xl border border-cyan-500/30 p-8 shadow-2xl">
            <!-- Status Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm font-medium text-green-400">
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <div class="space-y-6">
                <!-- Resend Verification -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full futuristic-btn">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-9 12V4" />
                        </svg>
                        Resend Verification Email
                    </button>
                </form>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-3 rounded-lg text-sm text-gray-400 border border-cyan-500/30 bg-black/40 hover:text-cyan-300 hover:border-cyan-400 transition-all duration-300">
                        Log Out
                    </button>
                </form>
            </div>
        </div>

        <!-- Decorative Blobs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl hidden sm:block"></div>
        <div class="absolute bottom-20 right-10 w-72 h-72 bg-cyan-500/10 rounded-full blur-3xl hidden sm:block"></div>
    </div>
</div>
@endsection
