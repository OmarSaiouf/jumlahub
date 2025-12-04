@php($title = 'إعادة تعيين كلمة المرور')
@php($subtitle = 'أدخل بريدك ثم كلمة المرور الجديدة لتحديث حسابك.')
@php($cta = 'حافظ على كلمة مرور قوية تجمع بين الأحرف والأرقام والرموز.')

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="auth-form">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                   class="form-input" placeholder="name@email.com">
        </div>

        <div class="form-group">
            <label for="password" class="form-label">كلمة المرور الجديدة</label>
            <input id="password" name="password" type="password" required autocomplete="new-password"
                   class="form-input" placeholder="••••••••">
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                   class="form-input" placeholder="أعد كتابة كلمة المرور">
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
            <span>تحديث كلمة المرور</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>

        <p class="auth-footer">
            تذكرت كلمة المرور؟ <a href="{{ route('login') }}">العودة لتسجيل الدخول</a>
        </p>
    </form>
@endsection
