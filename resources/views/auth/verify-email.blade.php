@php($title = __('main.verify'))
@php($subtitle = __('main.verify.subtitle'))
@php($cta = __('main.verify.cta'))

@extends('layouts.auth')

@section('content')
    <div class="card auth-card">
        <p class="muted">{{ __('main.verify.message1') }}</p>
        <p class="muted">{{ __('main.verify.message2') }}</p>

        <div class="hero-actions" style="margin-top: 16px;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-envelope-open-text"></i>
                    {{ __('main.verify.resend') }}
                </button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost">
                    {{ __('main.logout') }}
                </button>
            </form>
        </div>
    </div>
@endsection
