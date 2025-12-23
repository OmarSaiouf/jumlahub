@php($title = __('auth.main.login'))
@php($subtitle = __('auth.main.login.subtitle'))
@php($cta = __('auth.main.login.cta'))

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">{{ __('auth.main.mail') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                autocomplete="username" class="form-input" placeholder="name@email.com">
        </div>

        <div class="form-group">
            <div class="auth-links">
                <label for="password" class="form-label">{{ __('auth.main.password') }}</label>
                <a href="{{ route('password.request') }}">{{ __('auth.main.forgot_password') }}</a>
            </div>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                class="form-input" placeholder="••••••••">
        </div>

        <div class="auth-actions">
            <label class="auth-checkbox">
                <input type="checkbox" name="remember">
                <span>{{ __('auth.main.remember_me') }}</span>
            </label>
            <span class="muted">{{ __('auth.main.privacy_policy') }}</span>
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
            <span>{{ __('auth.main.login') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 5l7 7-7 7M5 12h14" />
            </svg>
        </button>

        <p class="auth-footer">
            {{ __('auth.main.havent_account') }} <a
                href="{{ route('register') }}">{{ __('auth.main.create_account') }}</a>
        </p>
    </form>
@endsection
