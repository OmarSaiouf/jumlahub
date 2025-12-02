@php($title = 'تأكيد كلمة المرور')
@php($subtitle = 'لحماية حسابك، يرجى إدخال كلمة المرور قبل المتابعة.')
@php($cta = 'تأكيد سريع للمتابعة في العمليات الحساسة.')

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div class="space-y-2">
            <label for="password" class="block text-sm font-semibold text-white">كلمة المرور</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                   class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-300/60 shadow-[0_15px_50px_rgba(0,0,0,0.35)] transition focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300/60">
        </div>

        <button type="submit"
                class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-500 px-4 py-3 text-lg font-semibold text-slate-950 shadow-[0_20px_60px_rgba(249,115,22,0.35)] transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-200">
            تأكيد المتابعة
        </button>
    </form>
@endsection
