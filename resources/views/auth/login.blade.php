@php($title = 'تسجيل الدخول')
@php($subtitle = 'سجل دخولك لمتابعة الطلبات وإدارة حسابك.')
@php($cta = 'لا تمتلك حساباً؟ أنشئ حساب تاجر جديد وابدأ الطلبات بالجملة بسهولة.')

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                   autocomplete="username" class="form-input" placeholder="name@email.com">
        </div>

        <div class="form-group">
            <div class="auth-links">
                <label for="password" class="form-label">كلمة المرور</label>
                <a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
            </div>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                   class="form-input" placeholder="••••••••">
        </div>

        <div class="auth-actions">
            <label class="auth-checkbox">
                <input type="checkbox" name="remember">
                <span>تذكرني على هذا الجهاز</span>
            </label>
            <span class="muted">دخولك يعني موافقتك على الشروط وسياسة الخصوصية.</span>
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
            <span>تسجيل الدخول</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 5l7 7-7 7M5 12h14" />
            </svg>
        </button>

        <p class="auth-footer">
            لا تملك حساباً؟ <a href="{{ route('register') }}">إنشاء حساب جديد</a>
        </p>
    </form>
@endsection
