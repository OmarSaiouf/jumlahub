@php($title = __('main.confirm_password'))
@php($subtitle = __('main.confirm_password.subtitle'))
@php($cta = __('main.confirm_password.cta'))

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="password" class="form-label">{{ __('main.password') }}</label>
            <input id="password" name="password" type="password" required autocomplete="current-password" class="form-input"
                placeholder="••••••••">
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
            <span>{{ __('main.confirm') }}</span>
        </button>
    </form>
@endsection
