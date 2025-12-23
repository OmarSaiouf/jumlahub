@php($title = __('main.reset_password'))
@php($subtitle = __('main.reset_password.subtitle'))
@php($cta = __('main.reset_password.cta'))

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="auth-form">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <label for="email" class="form-label">{{ __('main.mail') }}</label>
            <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                   class="form-input" placeholder="{{ __('main.mail_placeholder') }}">
        </div>

        <div class="form-group">
            <label for="password" class="form-label">{{ __('main.new_password') }}</label>
            <input id="password" name="password" type="password" required autocomplete="new-password"
                   class="form-input" placeholder="••••••••">
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">{{ __('main.new_password_confirmation') }}</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                   class="form-input" placeholder="••••••••">
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
            <span>{{ __('main.reset_password.button') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>

        <p class="auth-footer">
            {{ __('main.qus') }} <a href="{{ route('login') }}">{{ __('main.login_go_back') }}</a>
        </p>
    </form>
@endsection
