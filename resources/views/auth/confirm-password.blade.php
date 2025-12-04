@php($title = 'تأكيد كلمة المرور')
@php($subtitle = 'لأمان حسابك نحتاج تأكيد كلمة المرور قبل المتابعة.')
@php($cta = 'لن يتم استخدام البيانات إلا للتحقق من هويتك وحماية حسابك.')

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
        @csrf

        <div class="form-group">
            <label for="password" class="form-label">كلمة المرور</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                   class="form-input" placeholder="••••••••">
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
            <span>تأكيد</span>
        </button>
    </form>
@endsection
