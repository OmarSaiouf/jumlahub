@php($title = 'التحقق بخطوتين')
@php($subtitle = 'أدخل رمز المصادقة من التطبيق أو استخدم رمز الاسترداد الاحتياطي.')
@php($cta = 'في حال فقدت الوصول للتطبيق يمكنك تسجيل الدخول باستخدام رموز الاسترداد.')

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('two-factor.login.store') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="code" class="form-label">رمز المصادقة (6 أرقام)</label>
            <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code"
                   class="form-input" placeholder="123456">
        </div>

        <div class="form-group">
            <label for="recovery_code" class="form-label">رمز الاسترداد</label>
            <input id="recovery_code" name="recovery_code" type="text" autocomplete="one-time-code"
                   class="form-input" placeholder="XXXX-XXXX">
            <p class="muted">استخدم رمز الاسترداد إذا تعذر الوصول إلى تطبيق المصادقة.</p>
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
            <span>تأكيد الدخول</span>
        </button>

        <p class="auth-footer">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-twofactor').submit();">
                تسجيل الخروج والعودة للشاشة السابقة
            </a>
        </p>
    </form>

    <form id="logout-twofactor" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>
@endsection
