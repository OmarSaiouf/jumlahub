@php($title = __('main.two_factor.challenge'))
@php($subtitle = __('main.two_factor.challenge.subtitle'))
@php($cta = __('main.two_factor.challenge.cta'))

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('two-factor.login.store') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="code" class="form-label">{{ __('main.two_factor.code') }}</label>
            <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code"
                class="form-input" placeholder="123456">
        </div>

        <div class="form-group">
            <label for="recovery_code" class="form-label">{{ __('main.two_factor.recovery_code') }}</label>
            <input id="recovery_code" name="recovery_code" type="text" autocomplete="one-time-code" class="form-input"
                placeholder="XXXX-XXXX">
            <p class="muted">{{ __('main.two_factor.recovery_code.description') }}</p>
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
            <span>{{ __('main.two_factor.challenge.button') }}</span>
        </button>

        <p class="auth-footer">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-twofactor').submit();">
                {{ __('main.two_factor.challenge.logout') }}
            </a>
        </p>
    </form>

    <form id="logout-twofactor" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>
@endsection
