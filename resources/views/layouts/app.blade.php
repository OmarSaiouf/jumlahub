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
        <div class="absolute -left-32 top-[-14rem] h-96 w-96 rounded-full bg-orange-500/12 blur-[120px]"></div>
        <div class="absolute bottom-[-12rem] right-[-10rem] h-[28rem] w-[28rem] rounded-full bg-white/5 blur-[140px]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_15%_20%,rgba(255,117,15,0.05),transparent_35%),radial-gradient(circle_at_80%_0%,rgba(255,255,255,0.05),transparent_25%)]"></div>
    </div>

    <div class="relative mx-auto flex min-h-screen max-w-6xl flex-col px-6 py-8 lg:px-10">
        <header class="mb-10 flex flex-col gap-4 rounded-3xl border border-white/5 bg-slate-900/70 px-6 py-4 shadow-[0_12px_40px_rgba(0,0,0,0.35)] backdrop-blur-xl md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-500/20 text-lg font-semibold text-orange-200 ring-1 ring-orange-400/40">
                    {{ str(config('app.name', 'App'))->substr(0, 2)->upper() }}
                </div>
                <div>
                    <p class="text-xs uppercase tracking-[0.25em] text-orange-200/70">لوحة التحكم</p>
                    <p class="text-lg font-semibold text-white">{{ config('app.name', 'Laravel') }}</p>
                </div>
            </div>
            <div class="flex flex-wrap items-center gap-3 text-sm">
                <div class="rounded-xl border border-white/10 bg-white/5 px-4 py-2 text-white/80">
                    <span class="text-orange-200">{{ auth()->user()->name }}</span>
                    <span class="text-slate-300/70">• {{ auth()->user()->email }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="rounded-xl bg-gradient-to-r from-orange-500 via-amber-500 to-orange-500 px-4 py-2 font-semibold text-slate-950 shadow-lg shadow-orange-500/25 transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-orange-300">
                        تسجيل الخروج
                    </button>
                </form>
            </div>
        </header>

        <main class="relative flex-1">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-green-400/30 bg-green-500/10 px-4 py-3 text-sm text-green-50 shadow-inner shadow-green-500/10">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 space-y-2 rounded-2xl border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-50 shadow-inner shadow-red-500/10">
                    <p class="font-semibold">يرجى التحقق من المدخلات التالية:</p>
                    <ul class="list-disc space-y-1 pr-5 text-red-50/90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
