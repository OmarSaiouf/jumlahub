@php($title = __('main.forgot_password_request'))
@php($subtitle = __('main.forgot_password_request.subtitle'))
@php($cta = __('main.forgot_password_request.cta'))

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">{{ __('main.mail') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                autocomplete="username" class="form-input" placeholder="{{ __('main.mail_placeholder') }}">
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
            <span>{{ __('main.forgot_password_request.button') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>

        <p class="auth-footer">
            {{ __('main.qus') }} <a href="{{ route('login') }}">{{ __('main.login_go_back') }}</a>
        </p>
    </form>
@endsection
