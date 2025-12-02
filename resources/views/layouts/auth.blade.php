<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-50 antialiased">
    <div class="pointer-events-none fixed inset-0 overflow-hidden">
        <div class="absolute -left-24 top-[-12rem] h-80 w-80 rounded-full bg-orange-500/15 blur-[110px]"></div>
        <div class="absolute bottom-[-10rem] right-[-6rem] h-96 w-96 rounded-full bg-amber-400/10 blur-[120px]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(255,117,15,0.06),transparent_35%),radial-gradient(circle_at_80%_10%,rgba(255,255,255,0.03),transparent_30%)]"></div>
    </div>

    <div class="relative mx-auto flex min-h-screen max-w-6xl items-center px-6 py-12 lg:px-10">
        <div class="grid w-full grid-cols-1 gap-10 lg:grid-cols-[1.05fr,0.95fr]">
            <section class="hidden flex-col justify-between rounded-3xl border border-white/5 bg-gradient-to-br from-white/5 via-white/0 to-orange-500/5 p-8 shadow-[0_25px_70px_rgba(0,0,0,0.35)] backdrop-blur-xl lg:flex">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500/20 text-lg font-semibold text-orange-200 ring-1 ring-orange-400/40">
                        {{ str(config('app.name', 'App'))->substr(0, 2)->upper() }}
                    </div>
                    <div>
                        <p class="text-xs text-orange-200/80">منصة مؤمنة</p>
                        <p class="text-lg font-semibold text-white">{{ config('app.name', 'Laravel') }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-2xl font-semibold leading-relaxed text-white">
                        تجربة دخول سلسة ومحمية بخطوتين مع تصميم أنيق متناسق.
                    </p>
                    <ul class="space-y-3 text-sm text-slate-200/80">
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-orange-400 shadow-[0_0_0_4px_rgba(255,117,15,0.18)]"></span>
                            <span>تصميم عربي بالكامل مع دعم الاتجاه من اليمين لليسار.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-orange-400 shadow-[0_0_0_4px_rgba(255,117,15,0.18)]"></span>
                            <span>مصادقة ثنائية، وإدارة كلمات المرور، وروابط استعادة أنيقة.</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-orange-400 shadow-[0_0_0_4px_rgba(255,117,15,0.18)]"></span>
                            <span>تجربة متناسقة على سطح المكتب والجوال.</span>
                        </li>
                    </ul>
                </div>

                <div class="flex items-center justify-between rounded-2xl border border-white/10 bg-white/5 px-5 py-4 text-sm text-white/80">
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-wide text-orange-200/80">الخطوة التالية</p>
                        <p class="font-semibold text-white">{{ $cta ?? 'تابع تسجيل الدخول أو إنشاء الحساب خلال لحظات.' }}</p>
                    </div>
                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-500/20 text-orange-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </div>
            </section>

            <main class="relative">
                <div class="rounded-3xl border border-white/5 bg-slate-900/70 p-8 shadow-[0_25px_80px_rgba(0,0,0,0.35)] backdrop-blur-xl">
                    <div class="flex items-start justify-between gap-4">
                        <div class="space-y-1">
                            <p class="text-xs uppercase tracking-[0.2em] text-orange-200/70">أمان وحماية</p>
                            <h1 class="text-3xl font-semibold text-white">{{ $title ?? 'مساحة المستخدم' }}</h1>
                            @isset($subtitle)
                                <p class="text-sm text-slate-200/80">{{ $subtitle }}</p>
                            @endisset
                        </div>
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500/15 text-orange-200 ring-1 ring-orange-400/40">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M12 11c1.657 0 3-1.567 3-3.5S13.657 4 12 4s-3 1.567-3 3.5S10.343 11 12 11zM5.5 20a6.5 6.5 0 0 1 13 0" />
                            </svg>
                        </div>
                    </div>

                    @if (session('status'))
                        <div class="mt-6 rounded-2xl border border-green-400/30 bg-green-500/10 px-4 py-3 text-sm text-green-50 shadow-inner shadow-green-500/10">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mt-6 space-y-2 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-50 shadow-inner shadow-red-500/10">
                            <p class="font-semibold">تأكد من المدخلات التالية:</p>
                            <ul class="list-disc space-y-1 pr-5 text-red-50/90">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mt-8">
                        {{ $slot ?? '' }}
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
