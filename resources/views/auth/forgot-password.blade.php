@php($title = 'استرجاع كلمة المرور')
@php($subtitle = 'أدخل بريدك الإلكتروني وسنرسل لك رابط إعادة التعيين.')
@php($cta = 'تأكد من بريدك الوارد أو مجلد الرسائل غير المرغوبة للعثور على الرابط.')

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="form-input" placeholder="name@email.com">
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
            <span>إرسال رابط الاستعادة</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>

        <p class="auth-footer">
            تذكرت كلمة المرور؟ <a href="{{ route('login') }}">العودة لتسجيل الدخول</a>
        </p>
    </form>
@endsection
