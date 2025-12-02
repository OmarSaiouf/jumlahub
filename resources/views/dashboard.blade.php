@php($title = 'لوحة التحكم')
@php($user = auth()->user()->fresh())

@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 rounded-3xl border border-white/5 bg-gradient-to-r from-slate-900/80 via-slate-900/70 to-orange-500/15 p-6 shadow-[0_25px_70px_rgba(0,0,0,0.35)] backdrop-blur-xl lg:flex-row lg:items-center lg:justify-between">
            <div class="space-y-2">
                <p class="text-xs uppercase tracking-[0.25em] text-orange-200/70">مرحبا {{ $user->name }}</p>
                <h2 class="text-2xl font-semibold text-white">تحكم كامل ببياناتك وأمانك</h2>
                <p class="text-sm text-slate-200/80">تأكد من تحديث بيانات الحساب وتشغيل المصادقة الثنائية لأعلى مستويات الحماية.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="rounded-xl bg-white/5 px-4 py-2 text-sm text-white/80">
                    البريد موثق ✓
                </div>
                <div class="rounded-xl px-4 py-2 text-sm font-semibold {{ $user->hasEnabledTwoFactorAuthentication() ? 'bg-green-500/15 text-green-200 border border-green-400/30' : 'bg-amber-500/15 text-amber-100 border border-amber-400/30' }}">
                    {{ $user->hasEnabledTwoFactorAuthentication() ? 'المصادقة الثنائية مفعّلة' : 'المصادقة الثنائية متوقفة' }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <section class="rounded-3xl border border-white/5 bg-slate-900/70 p-6 shadow-[0_20px_60px_rgba(0,0,0,0.35)] backdrop-blur-xl">
                <div class="flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-[0.2em] text-orange-200/70">الملف الشخصي</p>
                        <h3 class="text-xl font-semibold text-white">تحديث البيانات</h3>
                    </div>
                </div>

                <form method="POST" action="{{ route('user-profile-information.update') }}" class="mt-5 space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-semibold text-white">الاسم الكامل</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autocomplete="name"
                               class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-300/60 shadow-inner shadow-black/30 transition focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300/60">
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-white">البريد الإلكتروني</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                               class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-300/60 shadow-inner shadow-black/30 transition focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300/60">
                    </div>

                    <button type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-500 px-4 py-3 text-sm font-semibold text-slate-950 shadow-[0_15px_40px_rgba(249,115,22,0.35)] transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-200">
                        حفظ التغييرات
                    </button>
                </form>
            </section>

            <section class="rounded-3xl border border-white/5 bg-slate-900/70 p-6 shadow-[0_20px_60px_rgba(0,0,0,0.35)] backdrop-blur-xl">
                <div class="flex items-center justify-between">
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-[0.2em] text-orange-200/70">الأمان</p>
                        <h3 class="text-xl font-semibold text-white">تغيير كلمة المرور</h3>
                    </div>
                </div>

                <form method="POST" action="{{ route('user-password.update') }}" class="mt-5 space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2">
                        <label for="current_password" class="block text-sm font-semibold text-white">كلمة المرور الحالية</label>
                        <input id="current_password" name="current_password" type="password" required autocomplete="current-password"
                               class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-300/60 shadow-inner shadow-black/30 transition focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300/60">
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-white">كلمة المرور الجديدة</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-300/60 shadow-inner shadow-black/30 transition focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300/60">
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-white">تأكيد كلمة المرور</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-300/60 shadow-inner shadow-black/30 transition focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300/60">
                    </div>

                    <button type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-500 px-4 py-3 text-sm font-semibold text-slate-950 shadow-[0_15px_40px_rgba(249,115,22,0.35)] transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-200">
                        تحديث كلمة المرور
                    </button>
                </form>
            </section>
        </div>

        <section class="rounded-3xl border border-white/5 bg-slate-900/70 p-6 shadow-[0_20px_60px_rgba(0,0,0,0.35)] backdrop-blur-xl">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-xs uppercase tracking-[0.2em] text-orange-200/70">التحقق بخطوتين</p>
                    <h3 class="text-xl font-semibold text-white">حماية إضافية للحساب</h3>
                </div>
                <div class="text-xs text-slate-300/80">
                    {{ $user->hasEnabledTwoFactorAuthentication() ? 'آخر تأكيد: ' . optional($user->two_factor_confirmed_at)->diffForHumans() : 'قم بالتفعيل لتوليد رموز الأمان.' }}
                </div>
            </div>

            @if (! $user->two_factor_secret)
                <div class="mt-5 flex flex-col gap-4 rounded-2xl border border-dashed border-white/15 bg-white/5 p-5 text-sm text-slate-200/85">
                    <p>قم بتفعيل المصادقة الثنائية لإنشاء رمز QR وربط تطبيق المصادقة (Google Authenticator، 1Password...).</p>
                    <form method="POST" action="{{ route('two-factor.enable') }}">
                        @csrf
                        <button type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-500 px-4 py-3 text-sm font-semibold text-slate-950 shadow-[0_15px_40px_rgba(249,115,22,0.35)] transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-200">
                            تفعيل التحقق بخطوتين
                        </button>
                    </form>
                </div>
            @elseif (! $user->hasEnabledTwoFactorAuthentication())
                <div class="mt-5 space-y-5">
                    <div class="rounded-2xl border border-amber-400/30 bg-amber-500/10 p-4 text-sm text-amber-50 shadow-inner shadow-amber-500/20">
                        تم إنشاء رمز سري، يرجى مسحه بتطبيق المصادقة ثم تأكيد أحد الرموز أدناه.
                    </div>

                    @if ($user->two_factor_secret)
                        <div class="rounded-2xl bg-white p-4 text-center shadow-inner shadow-black/10">
                            {!! $user->twoFactorQrCodeSvg() !!}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('two-factor.confirm') }}" class="space-y-3">
                        @csrf
                        <label for="code" class="block text-sm font-semibold text-white">رمز التطبيق بعد المسح</label>
                        <input id="code" name="code" type="text" inputmode="numeric" required autocomplete="one-time-code"
                               class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder:text-slate-300/60 shadow-inner shadow-black/30 transition focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-300/60">
                        <button type="submit"
                                class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-500 px-4 py-3 text-sm font-semibold text-slate-950 shadow-[0_15px_40px_rgba(249,115,22,0.35)] transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-200">
                            تأكيد التفعيل
                        </button>
                    </form>

                    <form method="POST" action="{{ route('two-factor.disable') }}" class="text-center">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="text-sm font-semibold text-red-200 underline decoration-red-200/70 decoration-2 underline-offset-4 hover:text-red-100">
                            إلغاء العملية
                        </button>
                    </form>
                </div>
            @else
                <div class="mt-5 grid gap-5 lg:grid-cols-[1fr,0.7fr]">
                    <div class="space-y-4 rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-sm font-semibold text-white">رمز QR الحالي</p>
                        <div class="rounded-xl bg-white p-4 text-center shadow-inner shadow-black/10">
                            {!! $user->twoFactorQrCodeSvg() !!}
                        </div>
                    </div>

                    <div class="space-y-4 rounded-2xl border border-white/10 bg-white/5 p-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-white">رموز الاستعادة</p>
                            <form method="POST" action="{{ route('two-factor.regenerate-recovery-codes') }}">
                                @csrf
                                <button type="submit" class="text-xs font-semibold text-orange-200 hover:text-orange-100">
                                    توليد رموز جديدة
                                </button>
                            </form>
                        </div>
                        @if ($user->two_factor_recovery_codes)
                            <div class="grid grid-cols-1 gap-2 text-left text-xs text-slate-900">
                                @foreach ($user->recoveryCodes() as $code)
                                    <span class="rounded-lg bg-white px-3 py-2 text-center font-mono tracking-widest">{{ $code }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mt-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-slate-200/80">
                        احتفظ بهذه الرموز في مكان آمن لاستخدامها عند فقدان الوصول لتطبيق المصادقة.
                    </div>
                    <form method="POST" action="{{ route('two-factor.disable') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-2 rounded-2xl border border-red-400/40 bg-red-500/10 px-4 py-2 text-sm font-semibold text-red-50 transition hover:border-red-200/60 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-200/70">
                            إيقاف التحقق بخطوتين
                        </button>
                    </form>
                </div>
            @endif
        </section>
    </div>
@endsection
