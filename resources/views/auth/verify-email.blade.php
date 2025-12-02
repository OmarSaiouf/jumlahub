@php($title = 'تأكيد البريد الإلكتروني')
@php($subtitle = 'قم بتأكيد بريدك لمتابعة الدخول إلى لوحة التحكم.')
@php($cta = 'تحقق من صندوق الوارد أو أعد إرسال الرابط.')

@extends('layouts.auth')

@section('content')
    <div class="space-y-6 text-sm leading-relaxed text-slate-200/85">
        <p>شكراً لتسجيلك! قبل المتابعة، نحتاج لتأكيد بريدك الإلكتروني. أرسلنا رابط تحقق إلى بريدك.</p>
        <p>إذا لم يصلك الرابط أو انتهت صلاحيته، يمكنك طلب رابط جديد بالضغط على الزر أدناه.</p>
    </div>

    <div class="mt-8 flex flex-col gap-3 md:flex-row md:items-center">
        <form method="POST" action="{{ route('verification.send') }}" class="flex-1">
            @csrf
            <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-500 px-4 py-3 text-sm font-semibold text-slate-950 shadow-[0_20px_60px_rgba(249,115,22,0.35)] transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-200">
                إعادة إرسال رابط التفعيل
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.03-2A8.5 8.5 0 1 0 12 20.5a8.5 8.5 0 0 0 7.612-11.333" />
                </svg>
            </button>
        </form>
        <form method="POST" action="{{ route('logout') }}" class="w-full md:w-auto">
            @csrf
            <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold text-white transition hover:border-orange-300/60 hover:text-orange-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-200/60">
                تسجيل الخروج
            </button>
        </form>
    </div>
@endsection
