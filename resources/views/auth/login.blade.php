<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #e0e7ff;
            --primary-dark: #4338ca;
            --secondary: #6b7280;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            --light: #f8fafc;
            --dark: #1e293b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            font-size: 14px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #334155;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Background Pattern */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(79, 70, 229, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(245, 158, 11, 0.1) 0%, transparent 50%);
            z-index: -1;
            animation: patternMove 20s linear infinite;
        }

        /* Main Container */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* Compact Login Card */
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow:
                0 10px 40px rgba(0, 0, 0, 0.08),
                0 0 0 1px rgba(0, 0, 0, 0.02);
            max-width: 400px;
            width: 100%;
            overflow: hidden;
            position: relative;
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: cardFloat 6s ease-in-out infinite;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow:
                0 15px 50px rgba(0, 0, 0, 0.12),
                0 0 0 1px rgba(79, 70, 229, 0.1);
            animation-play-state: paused;
        }

        /* Card Header - More Compact */
        .login-header {
            background: linear-gradient(135deg, var(--primary), #6366f1);
            color: white;
            padding: 30px 25px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #10b981, #8b5cf6, #ec4899);
            animation: shimmer 2s linear infinite;
        }

        .company-logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            position: relative;
            z-index: 1;
            backdrop-filter: blur(5px);
            border: 1.5px solid rgba(255, 255, 255, 0.25);
            animation: logoFloat 3s ease-in-out infinite;
        }

        .company-logo i {
            font-size: 24px;
            color: white;
        }

        .login-header h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
            position: relative;
            z-index: 1;
        }

        .login-header p {
            font-size: 13px;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        /* Card Body - More Compact */
        .login-body {
            padding: 30px 25px;
        }

        /* Compact Form Styles */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-group {
            position: relative;
        }

        .form-control {
            padding: 12px 15px 12px 40px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s ease;
            background: white;
            height: 46px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
            outline: none;
            transform: translateY(-1px);
        }

        .form-control::placeholder {
            color: #94a3b8;
            font-size: 13px;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 16px;
            z-index: 2;
            transition: all 0.2s ease;
        }

        .form-control:focus~.input-icon {
            color: var(--primary);
            transform: translateY(-50%) scale(1.1);
        }

        /* Compact Password Toggle */
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s ease;
            z-index: 2;
            padding: 4px;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Compact Options */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-check-input {
            width: 16px;
            height: 16px;
            border: 2px solid #cbd5e1;
            border-radius: 4px;
            cursor: pointer;
            margin: 0;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-label {
            font-size: 13px;
            color: #64748b;
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Compact Login Button */
        .login-btn {
            width: 100%;
            padding: 14px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.25);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn i {
            font-size: 16px;
            transition: transform 0.3s ease;
        }

        .login-btn:hover i {
            transform: translateX(4px);
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s ease;
        }

        .login-btn:hover::before {
            left: 100%;
        }

        /* Register Link - More Compact */
        .register-link {
            text-align: center;
            font-size: 13px;
            color: #64748b;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .register-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Theme Toggle - More Compact */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 100;
        }

        .theme-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: white;
            border: 1.5px solid #e2e8f0;
            color: var(--primary);
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .theme-btn:hover {
            transform: rotate(15deg) scale(1.05);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.12);
        }

        /* Loading Animation */
        .loading {
            display: none;
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Validation Messages */
        .invalid-feedback {
            display: none;
            font-size: 11px;
            color: var(--danger);
            margin-top: 4px;
            animation: fadeIn 0.3s ease;
        }

        .is-invalid {
            border-color: var(--danger) !important;
        }

        .is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        }

        /* Password Strength */
        .password-strength {
            font-size: 11px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                padding: 15px;
            }

            .login-card {
                max-width: 100%;
            }

            .login-header {
                padding: 25px 20px;
            }

            .login-body {
                padding: 25px 20px;
            }

            .company-logo {
                width: 50px;
                height: 50px;
            }

            .company-logo i {
                font-size: 20px;
            }

            .login-header h1 {
                font-size: 20px;
            }

            .login-header p {
                font-size: 12px;
            }

            .theme-btn {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }

            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }

            .forgot-link {
                align-self: flex-end;
            }
        }

        /* Animations */
        @keyframes patternMove {
            0% {
                transform: scale(1) rotate(0deg);
            }

            50% {
                transform: scale(1.05) rotate(180deg);
            }

            100% {
                transform: scale(1) rotate(360deg);
            }
        }

        @keyframes cardFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes logoFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-8px);
            }

            75% {
                transform: translateX(8px);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Dark Theme */
        .dark-theme {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #e2e8f0;
        }

        .dark-theme .login-card {
            background: #1e293b;
            box-shadow:
                0 10px 40px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        .dark-theme .form-control {
            background: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }

        .dark-theme .form-control::placeholder {
            color: #94a3b8;
        }

        .dark-theme .register-link {
            border-top-color: #334155;
            color: #94a3b8;
        }

        .dark-theme .theme-btn {
            background: #334155;
            border-color: #475569;
            color: #e2e8f0;
        }

        .dark-theme .form-check-label {
            color: #cbd5e1;
        }

        /* Success State */
        .success-state {
            background: linear-gradient(135deg, #10b981, #059669) !important;
        }

        /* Error Animation */
        .shake {
            animation: shake 0.5s ease-in-out;
        }

        /* Floating particles */
        .floating-particle {
            position: absolute;
            background: rgba(79, 70, 229, 0.1);
            border-radius: 50%;
            animation: floatParticle 15s linear infinite;
            z-index: -1;
        }
    </style>
</head>

<body>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Background Pattern -->
    <div class="bg-pattern"></div>

    <!-- Floating Particles -->
    <div class="floating-particles"></div>

    <!-- Theme Toggle -->
    <div class="theme-toggle">
        <button class="theme-btn" id="themeToggle">
            <i class="bi bi-moon"></i>
        </button>
    </div>

    <!-- Main Container -->
    <div class="login-container">
        <div class="login-card">
            <!-- Card Header -->
            <div class="login-header">
                <div class="company-logo">
                    <i class="bi bi-people-fill"></i>
                </div>
                <h1>HR<span style="font-weight: 300;">Manage</span></h1>
                <p>Employee Management System</p>
            </div>

            <!-- Card Body -->
            <div class="login-body">

                <form id="loginForm" method="POST" action="{{ route('login') }}">
                    @csrf
                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email" value="__('Email')" class="form-label">
                            Email Address
                        </label>
                        <div class="input-group">
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                                id="email" placeholder="admin@hrmange.com" required>
                            <span class="input-icon">
                                <i class="bi bi-person"></i>
                            </span>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label for="password" value="__('Password')" class="form-label">
                                Password
                            </label>
                            <div class="password-strength" id="passwordStrength"></div>
                        </div>
                        <div class="input-group">
                            <input class="form-control" id="password" type="password" name="password"
                                placeholder="Enter your password" required>
                            <span class="input-icon">
                                <i class="bi bi-lock"></i>
                            </span>
                            <button type="button" class="password-toggle" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Options -->
                    <div class="form-options">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember_me" name="remember" checked>
                            <label class="form-check-label" for="remember_me">
                                Remember me
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                     
                    </div>

                    <!-- Login Button -->
                    <button type="submit" class="login-btn" id="submitBtn">
                        <span>Sign In</span>
                        <i class="bi bi-arrow-right"></i>
                        <div class="loading" id="loadingSpinner"></div>
                    </button>

                    <!-- Register Link -->
                    <div class="register-link">
                        Need access?
                        <a href="#" id="registerLink">Contact Administrator</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- <script>
        // DOM Ready
        document.addEventListener('DOMContentLoaded', function() {
            // Create floating particles
            createParticles();

            // Theme Toggle
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = themeToggle.querySelector('i');

            themeToggle.addEventListener('click', function() {
                document.body.classList.toggle('dark-theme');
                if (themeIcon.classList.contains('bi-moon')) {
                    themeIcon.classList.remove('bi-moon');
                    themeIcon.classList.add('bi-sun');
                    // Add rotation animation
                    themeToggle.style.transform = 'rotate(180deg) scale(1.1)';
                } else {
                    themeIcon.classList.remove('bi-sun');
                    themeIcon.classList.add('bi-moon');
                    themeToggle.style.transform = 'rotate(0deg) scale(1.1)';
                }

                setTimeout(() => {
                    themeToggle.style.transform = '';
                }, 300);
            });

            // Password Toggle
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const toggleIcon = togglePassword.querySelector('i');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                toggleIcon.classList.toggle('bi-eye');
                toggleIcon.classList.toggle('bi-eye-slash');

                // Add bounce animation
                this.style.transform = 'translateY(-50%) scale(1.2)';
                setTimeout(() => {
                    this.style.transform = 'translateY(-50%) scale(1)';
                }, 200);
            });

            // Password Strength Indicator
            const passwordStrength = document.getElementById('passwordStrength');

            passwordInput.addEventListener('input', function() {
                const password = this.value;

                if (password.length === 0) {
                    passwordStrength.innerHTML = '';
                    passwordStrength.style.color = '';
                    return;
                }

                let strength = '';
                let color = '';

                if (password.length < 6) {
                    strength = 'Weak';
                    color = '#ef4444';
                } else if (password.length < 10) {
                    strength = 'Good';
                    color = '#f59e0b';
                } else {
                    strength = 'Strong';
                    color = '#10b981';
                }

                passwordStrength.innerHTML = `<i class="bi bi-shield-check"></i> ${strength}`;
                passwordStrength.style.color = color;

                // Animate the strength indicator
                passwordStrength.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    passwordStrength.style.transform = 'scale(1)';
                }, 200);
            });

            // Form Validation
            const loginForm = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInputField = document.getElementById('password');
            const submitBtn = document.getElementById('submitBtn');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const submitText = submitBtn.querySelector('span');

            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            emailInput.addEventListener('blur', function() {
                if (!validateEmail(this.value)) {
                    this.classList.add('is-invalid');
                    document.getElementById('emailError').style.display = 'block';
                    this.classList.add('shake');
                    setTimeout(() => this.classList.remove('shake'), 500);
                } else {
                    this.classList.remove('is-invalid');
                    document.getElementById('emailError').style.display = 'none';
                }
            });

            passwordInputField.addEventListener('blur', function() {
                if (this.value.length < 6) {
                    this.classList.add('is-invalid');
                    document.getElementById('passwordError').style.display = 'block';
                    this.classList.add('shake');
                    setTimeout(() => this.classList.remove('shake'), 500);
                } else {
                    this.classList.remove('is-invalid');
                    document.getElementById('passwordError').style.display = 'none';
                }
            });

            // Form Submission
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();

                let isValid = true;

                // Validate email
                if (!validateEmail(emailInput.value)) {
                    emailInput.classList.add('is-invalid');
                    document.getElementById('emailError').style.display = 'block';
                    emailInput.classList.add('shake');
                    setTimeout(() => emailInput.classList.remove('shake'), 500);
                    isValid = false;
                }

                // Validate password
                if (passwordInputField.value.length < 6) {
                    passwordInputField.classList.add('is-invalid');
                    document.getElementById('passwordError').style.display = 'block';
                    passwordInputField.classList.add('shake');
                    setTimeout(() => passwordInputField.classList.remove('shake'), 500);
                    isValid = false;
                }

                if (!isValid) {
                    // Shake the entire form
                    loginForm.classList.add('shake');
                    setTimeout(() => {
                        loginForm.classList.remove('shake');
                    }, 500);
                    return;
                }

                // Show loading
                submitText.style.display = 'none';
                submitBtn.querySelector('i').style.display = 'none';
                loadingSpinner.style.display = 'block';
                submitBtn.disabled = true;
                submitBtn.style.cursor = 'not-allowed';

                // Simulate API call with particles effect
                createSuccessParticles();

                setTimeout(() => {
                    // Success animation
                    submitBtn.classList.add('success-state');
                    loadingSpinner.style.display = 'none';

                    // Success icon and text
                    submitBtn.innerHTML = `
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Welcome!</span>
                    `;

                    // Success sound (optional)
                    playSuccessSound();

                    // Animate card
                    const card = document.querySelector('.login-card');
                    card.style.animation = 'pulse 0.5s ease 2';

                    // Redirect to dashboard after 1.5 seconds
                    setTimeout(() => {
                        // For demo: show success message
                        submitBtn.innerHTML = `
                            <i class="bi bi-arrow-right"></i>
                            <span>Redirecting...</span>
                        `;
                        submitBtn.classList.remove('success-state');

                        setTimeout(() => {
                            alert('Login successful! Redirecting to dashboard...');
                            // Uncomment for actual redirect:
                            // window.location.href = 'dashboard.html';
                            resetForm();
                        }, 1000);
                    }, 1500);
                }, 1500);
            });

            function resetForm() {
                setTimeout(() => {
                    loginForm.reset();
                    submitBtn.innerHTML = `
                        <span>Sign In</span>
                        <i class="bi bi-arrow-right"></i>
                        <div class="loading" id="loadingSpinner"></div>
                    `;
                    submitBtn.disabled = false;
                    submitBtn.style.cursor = 'pointer';

                    // Clear validation
                    emailInput.classList.remove('is-invalid');
                    passwordInputField.classList.remove('is-invalid');
                    document.getElementById('emailError').style.display = 'none';
                    document.getElementById('passwordError').style.display = 'none';
                    passwordStrength.innerHTML = '';

                    // Reset card animation
                    const card = document.querySelector('.login-card');
                    card.style.animation = 'cardFloat 6s ease-in-out infinite';
                }, 500);
            }

            // Forgot Password
            document.getElementById('forgotPassword').addEventListener('click', function(e) {
                e.preventDefault();

                // Animate the link
                this.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);

                // Show forgot password modal
                const email = prompt('Enter your email to reset password:');
                if (email && validateEmail(email)) {
                    alert(`Password reset link sent to ${email}`);
                } else if (email) {
                    alert('Please enter a valid email address.');
                }
            });

            // Register Link
            document.getElementById('registerLink').addEventListener('click', function(e) {
                e.preventDefault();

                // Animate the link
                this.style.transform = 'scale(1.1)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 200);

                alert(
                    'Please contact your system administrator at:\n\nadmin@hrmanage.com\n\nOr call: +1 (555) 123-4567'
                );
            });

            // Add focus animations
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Create floating particles function
            function createParticles() {
                const container = document.querySelector('.floating-particles') ||
                    document.body.appendChild(document.createElement('div'));
                container.className = 'floating-particles';
                container.style.position = 'fixed';
                container.style.top = '0';
                container.style.left = '0';
                container.style.width = '100%';
                container.style.height = '100%';
                container.style.zIndex = '-1';
                container.style.pointerEvents = 'none';

                for (let i = 0; i < 15; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'floating-particle';

                    // Random properties
                    const size = Math.random() * 60 + 20;
                    const posX = Math.random() * 100;
                    const posY = Math.random() * 100;
                    const duration = Math.random() * 20 + 10;
                    const delay = Math.random() * 5;
                    const opacity = Math.random() * 0.1 + 0.05;

                    particle.style.width = `${size}px`;
                    particle.style.height = `${size}px`;
                    particle.style.left = `${posX}%`;
                    particle.style.top = `${posY}%`;
                    particle.style.animationDuration = `${duration}s`;
                    particle.style.animationDelay = `${delay}s`;
                    particle.style.opacity = opacity;

                    // Random color
                    const colors = [
                        'rgba(79, 70, 229, 0.1)',
                        'rgba(16, 185, 129, 0.1)',
                        'rgba(245, 158, 11, 0.1)',
                        'rgba(236, 72, 153, 0.1)'
                    ];
                    particle.style.background = colors[Math.floor(Math.random() * colors.length)];

                    container.appendChild(particle);
                }
            }

            // Success particles animation
            function createSuccessParticles() {
                const particlesContainer = document.createElement('div');
                particlesContainer.style.position = 'fixed';
                particlesContainer.style.top = '0';
                particlesContainer.style.left = '0';
                particlesContainer.style.width = '100%';
                particlesContainer.style.height = '100%';
                particlesContainer.style.zIndex = '1000';
                particlesContainer.style.pointerEvents = 'none';
                document.body.appendChild(particlesContainer);

                const card = document.querySelector('.login-card');
                const cardRect = card.getBoundingClientRect();
                const centerX = cardRect.left + cardRect.width / 2;
                const centerY = cardRect.top + cardRect.height / 2;

                for (let i = 0; i < 20; i++) {
                    const particle = document.createElement('div');
                    particle.style.position = 'absolute';
                    particle.style.width = '10px';
                    particle.style.height = '10px';
                    particle.style.background = '#10b981';
                    particle.style.borderRadius = '50%';
                    particle.style.left = `${centerX}px`;
                    particle.style.top = `${centerY}px`;

                    // Random animation
                    const angle = Math.random() * Math.PI * 2;
                    const distance = Math.random() * 100 + 50;
                    const duration = Math.random() * 0.5 + 0.5;

                    particle.style.animation = `
                        particleOut ${duration}s ease-out forwards
                    `;

                    particle.style.setProperty('--angle', angle);
                    particle.style.setProperty('--distance', distance);

                    particlesContainer.appendChild(particle);

                    // Remove particle after animation
                    setTimeout(() => {
                        particle.remove();
                    }, duration * 1000);
                }

                // Remove container after all particles are gone
                setTimeout(() => {
                    particlesContainer.remove();
                }, 1000);
            }

            // Add particle animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes particleOut {
                    0% {
                        transform: translate(0, 0) scale(1);
                        opacity: 1;
                    }
                    100% {
                        transform: 
                            translate(
                                calc(cos(var(--angle)) * var(--distance) * 1px),
                                calc(sin(var(--angle)) * var(--distance) * 1px)
                            ) scale(0);
                        opacity: 0;
                    }
                }
                
                @keyframes floatParticle {
                    0%, 100% {
                        transform: translate(0, 0) rotate(0deg);
                    }
                    25% {
                        transform: translate(20px, -20px) rotate(90deg);
                    }
                    50% {
                        transform: translate(0, -40px) rotate(180deg);
                    }
                    75% {
                        transform: translate(-20px, -20px) rotate(270deg);
                    }
                }
            `;
            document.head.appendChild(style);

            // Optional success sound
            function playSuccessSound() {
                // This is a silent audio for the pattern
                // In production, you would use actual audio
                try {
                    const audioContext = new(window.AudioContext || window.webkitAudioContext)();
                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();

                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);

                    oscillator.frequency.setValueAtTime(523.25, audioContext.currentTime); // C5
                    oscillator.frequency.setValueAtTime(659.25, audioContext.currentTime + 0.1); // E5
                    oscillator.frequency.setValueAtTime(783.99, audioContext.currentTime + 0.2); // G5

                    gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);

                    oscillator.start();
                    oscillator.stop(audioContext.currentTime + 0.3);
                } catch (e) {
                    // Audio not supported, continue silently
                }
            }

            console.log('Compact Login Page Initialized');
        });
    </script> --}}
</body>

</html>
