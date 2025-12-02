@php($title = 'التحقق بخطوتين')
@php($subtitle = 'أدخل رمز المصادقة أو أحد رموز الاستعادة لمتابعة الدخول.')
@php($cta = 'أمان إضافي لحماية حسابك.')

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('two-factor.login.store') }}" class="space-y-5">
        @csrf

        <div class="space-y-2">
            <label for="code" class="block text-sm font-semibold text-white">رمز التطبيق (6 أرقام)</label>
            <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code"
                   class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-300/60 shadow-[0_15px_50px_rgba(0,0,0,0.35)] transition focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300/60"
                   placeholder="••••••">
        </div>

        <div class="space-y-2">
            <label for="recovery_code" class="block text-sm font-semibold text-white">أو رمز الاستعادة</label>
            <input id="recovery_code" name="recovery_code" type="text" autocomplete="one-time-code"
                   class="w-full rounded-2xl border border-dashed border-white/15 bg-white/5 px-4 py-3 text-white placeholder:text-slate-300/60 shadow-[0_15px_50px_rgba(0,0,0,0.35)] transition focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300/60"
                   placeholder="XXXX-XXXX">
            <p class="text-xs text-slate-300/80">املأ أحد الحقلين فقط.</p>
        </div>

        <button type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-500 px-4 py-3 text-lg font-semibold text-slate-950 shadow-[0_20px_60px_rgba(249,115,22,0.35)] transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-200">
            تأكيد ومتابعة
        </button>

        <p class="text-center text-sm text-slate-200/80">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-twofactor').submit();"
               class="font-semibold text-orange-200 hover:text-orange-100">
                الرجوع لتسجيل الدخول
            </a>
        </p>
    </form>

    <form id="logout-twofactor" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>
@endsection
