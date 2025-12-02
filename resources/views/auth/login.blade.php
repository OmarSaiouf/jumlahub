@php($title = 'تسجيل الدخول')
@php($subtitle = 'أدخل بياناتك للوصول للوحة التحكم الآمنة.')
@php($cta = 'سجل دخولك واستفد من الحماية بخطوتين.')

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-white">البريد الإلكتروني</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                autocomplete="username"
                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-300/60 shadow-[0_15px_50px_rgba(0,0,0,0.35)] transition focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300/60">
        </div>

        <div class="space-y-2">
            <div class="flex items-center justify-between text-sm text-white">
                <label for="password" class="font-semibold">كلمة المرور</label>
                <a href="{{ route('password.request') }}" class="text-orange-200 hover:text-orange-100">نسيت كلمة
                    المرور؟</a>
            </div>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-300/60 shadow-[0_15px_50px_rgba(0,0,0,0.35)] transition focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300/60">
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-200/80">
            <input type="checkbox" name="remember"
                class="h-4 w-4 rounded border-white/20 bg-white/10 text-orange-400 focus:ring-orange-300/70">
            <span>تذكرني في هذا الجهاز</span>
        </label>

        <button type="submit"
            class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-500 px-4 py-3 text-lg font-semibold text-slate-950 shadow-[0_20px_60px_rgba(249,115,22,0.35)] transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-200">
            دخول آمن
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 5l7 7-7 7M5 12h14" />
            </svg>
        </button>

        <p class="text-center text-sm text-slate-200/80">
            ليس لديك حساب؟ <a href="{{ route('register') }}"
                class="font-semibold text-orange-200 hover:text-orange-100">أنشئ حساباً جديداً</a>
        </p>
    </form>
@endsection
