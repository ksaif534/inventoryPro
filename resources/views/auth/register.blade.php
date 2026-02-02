@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="space-y-5">
    <!-- Page Title -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-white mb-2">Create Account</h2>
        <p class="text-gray-400">Join our inventory management platform</p>
    </div>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        
        <fieldset class="space-y-5">
            <legend class="sr-only">Registration Form</legend>

            <!-- Name -->
        <div class="space-y-2">
            <label for="name" class="block text-sm font-semibold text-white">Full Name</label>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   autofocus
                   autocomplete="name"
                   class="w-full glass-input"
                   placeholder="Enter your full name">
            @error('name')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-white">Email Address</label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
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
                   autocomplete="new-password"
                   class="w-full glass-input"
                   placeholder="Create a strong password">
            @error('password')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
            
            <!-- Password Strength Indicator -->
            <div class="mt-2" id="password-strength-container">
                <div class="flex justify-between items-center mb-1">
                    <span class="text-xs text-gray-400">Password Strength:</span>
                    <span id="strength-text" class="text-xs font-medium"></span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2">
                    <div id="strength-bar" class="h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                </div>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <label for="password_confirmation" class="block text-sm font-semibold text-white">Confirm Password</label>
            <input type="password"
                   id="password_confirmation"
                   name="password_confirmation"
                   required
                   autocomplete="new-password"
                   class="w-full glass-input"
                   placeholder="Confirm your password">
            @error('password_confirmation')
                <p class="text-sm text-red-400 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Already Registered -->
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" 
               class="text-sm text-cyan-400 hover:text-cyan-300 transition-colors">
                Already registered? Sign in
            </a>
        </div>

        <!-- Submit Button -->
        <button type="submit"
                class="w-full glass-button btn-primary px-4 py-3 text-center">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Create Account
        </button>
        </fieldset>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');
    
    // Form submission loading state
    form.addEventListener('submit', function(e) {
        submitButton.classList.add('btn-loading');
        submitButton.disabled = true;
    });
    
    // Password strength indicator
    if (passwordInput && strengthBar && strengthText) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = calculatePasswordStrength(password);
            updateStrengthIndicator(strength);
        });
        
        function calculatePasswordStrength(password) {
            let strength = 0;
            
            // Length check
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 25;
            
            // Character variety checks
            if (/[a-z]/.test(password)) strength += 12.5;
            if (/[A-Z]/.test(password)) strength += 12.5;
            if (/[0-9]/.test(password)) strength += 12.5;
            if (/[^a-zA-Z0-9]/.test(password)) strength += 12.5;
            
            return Math.min(strength, 100);
        }
        
        function updateStrengthIndicator(strength) {
            strengthBar.style.width = strength + '%';
            
            let color, text;
            if (strength <= 25) {
                color = 'bg-red-500';
                text = 'Weak';
            } else if (strength <= 50) {
                color = 'bg-orange-500';
                text = 'Fair';
            } else if (strength <= 75) {
                color = 'bg-yellow-500';
                text = 'Good';
            } else {
                color = 'bg-green-500';
                text = 'Strong';
            }
            
            strengthBar.className = `h-2 rounded-full transition-all duration-300 ${color}`;
            strengthText.textContent = text;
            strengthText.className = `text-xs font-medium ${color.replace('bg-', 'text-')}`;
        }
    }
    
    // Real-time validation feedback
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateInput(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('input-error')) {
                validateInput(this);
            }
            
            // Check password confirmation when password changes
            if (input.id === 'password' && passwordConfirmInput.value) {
                validatePasswordConfirmation();
            }
        });
    });
    
    function validateInput(input) {
        if (input.id === 'email') {
            validateEmail(input);
        } else if (input.id === 'password_confirmation') {
            validatePasswordConfirmation();
        } else {
            if (input.value.trim() === '') {
                input.classList.remove('input-success');
                input.classList.add('input-error');
            } else {
                input.classList.remove('input-error');
                input.classList.add('input-success');
            }
        }
    }
    
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
    
    function validatePasswordConfirmation() {
        if (passwordInput.value !== passwordConfirmInput.value) {
            passwordConfirmInput.classList.remove('input-success');
            passwordConfirmInput.classList.add('input-error');
        } else if (passwordConfirmInput.value !== '') {
            passwordConfirmInput.classList.remove('input-error');
            passwordConfirmInput.classList.add('input-success');
        }
    }
});
</script>
@endsection