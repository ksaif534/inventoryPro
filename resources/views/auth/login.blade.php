@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="space-y-5">
    <!-- Page Title -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-white mb-2">Welcome Back</h2>
        <p class="text-gray-400">Sign in to your inventory management account</p>
    </div>
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        
        <fieldset class="space-y-5">
            <legend class="sr-only">Login Form</legend>

            <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-white">Email Address</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}"
                   required 
                   autofocus 
                   autocomplete="username"
                   class="w-full glass-input"
                   placeholder="Enter your email address">
            @error('email')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-semibold text-white">Password</label>
            <input type="password"
                   id="password"
                   name="password"
                   required
                   autocomplete="current-password"
                   class="w-full glass-input"
                   placeholder="Enter your password">
            @error('password')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember" 
                   type="checkbox" 
                   name="remember" 
                   class="rounded border-gray-300 text-cyan-500 bg-white/10 focus:ring-cyan-500">
            <label for="remember" class="ml-2 text-sm text-gray-300">
                Remember me
            </label>
        </div>

        <!-- Forgot Password -->
        @if (Route::has('password.request'))
        <div class="text-center mt-4">
            <a href="{{ route('password.request') }}" 
               class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors">
                Forgot your password?
            </a>
        </div>
        @endif

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full glass-button btn-primary px-4 py-3 text-center">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
            </svg>
            Sign In
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
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateInput(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('input-error')) {
                validateInput(this);
            }
        });
    });
    
    function validateInput(input) {
        if (input.value.trim() === '') {
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