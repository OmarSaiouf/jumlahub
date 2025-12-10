@php($title = 'تأكيد البريد الإلكتروني')
@php($subtitle = 'تحقق من بريدك لتفعيل حسابك وإكمال التسجيل.')
@php($cta = 'لم يصلك البريد؟ أعد الإرسال أو تحقق من مجلد الرسائل غير المرغوبة.')

@extends('layouts.auth')

@section('content')
    <div class="card auth-card">
        <p class="muted">شكراً لانضمامك إلى JumlaHub. أرسلنا رابط تفعيل إلى بريدك الإلكتروني لتأكيد الحساب.</p>
        <p class="muted">إذا لم يصلك البريد خلال دقائق، يمكنك إعادة الإرسال أو تغيير البريد من إعدادات الحساب.</p>

        <div class="hero-actions" style="margin-top: 16px;">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-envelope-open-text"></i>
                    إعادة إرسال رابط التفعيل
                </button>
            </form>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost">
                    تسجيل الخروج
                </button>
            </form>
        </div>
    </div>
@endsection
