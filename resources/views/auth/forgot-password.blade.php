@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<div class="space-y-5">
    <!-- Page Title -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-white mb-2">Reset Password</h2>
        <p class="text-gray-400">Enter your email to receive a password reset link</p>
    </div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf
        
        <fieldset class="space-y-5">
            <legend class="sr-only">Password Reset Form</legend>

            <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-white">Email Address</label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus
                   class="w-full glass-input"
                   placeholder="Enter your email address">
            @error('email')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Back to Login -->
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" 
               class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Sign In
            </a>
        </div>

        <!-- Submit Button -->
        <button type="submit"
                class="w-full glass-button btn-primary px-4 py-3 text-center">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            Email Password Reset Link
        </button>
        </fieldset>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        submitButton.classList.add('btn-loading');
        submitButton.disabled = true;
    });
    
    // Add real-time validation feedback
    const emailInput = document.getElementById('email');
    emailInput.addEventListener('blur', function() {
        validateEmail(this);
    });
    
    emailInput.addEventListener('input', function() {
        if (this.classList.contains('input-error')) {
            validateEmail(this);
        }
    });
    
    function validateEmail(input) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (input.value.trim() === '' || !emailRegex.test(input.value)) {
            input.classList.remove('input-success');
            input.classList.add('input-error');
        } else {
            input.classList.remove('input-error');
            input.classList.add('input-success');
        }
    }
});
</script>
@endsection