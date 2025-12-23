<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name', 'JumlaHub') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="auth-page">
    <div class="auth-wrapper">
        <aside class="auth-aside">
            <div class="logo" aria-label="{{ config('app.name', 'JumlaHub') }}">
                <img class="logo-img" src="{{ asset('images/logo.png') }}"
                    alt="{{ config('app.name', 'JumlaHub') }} logo" loading="lazy">
            </div>
            <div class="chip">{{ __('auth.auth.aside.chip') }}</div>

            <h2>{{ __('auth.aside.title') }}</h2>
            <p>{{ __('auth.aside.description') }}</p>

            <ul class="feature-list">
                <li><span
                        class="pill">{{ __('auth.aside.features.supply_stability') }}</span>{{ __('auth.aside.features.supply_stability.note') }}
                </li>
                <li><span
                        class="pill">{{ __('auth.aside.features.negotiation') }}</span>{{ __('auth.aside.features.negotiation.note') }}
                </li>
                <li><span
                        class="pill">{{ __('auth.aside.features.pricing') }}</span>{{ __('auth.aside.features.pricing.note') }}
                </li>
            </ul>

            <div class="auth-stats">
                <div class="stat-card">
                    <span class="stat-number">+320</span>
                    <span class="stat-label">{{ __('auth.aside.stats.1') }}</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">92%</span>
                    <span class="stat-label">{{ __('auth.aside.stats.2') }}</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">{{ __('auth.aside.stats.3') }}</span>
                </div>
            </div>

            @isset($cta)
                <div class="auth-cta">{{ $cta }}</div>
            @endisset
        </aside>

        <main class="auth-main">
            <div class="section-head">
                <div>
                    <div class="eyebrow">{{ __('auth.main.chip') }}</div>
                    <h1 class="section-title">{{ $title ?? __('auth.main.login') }}</h1>
                    @isset($subtitle)
                        <p class="auth-subtitle">{{ $subtitle }}</p>
                    @endisset
                </div>
                <a href="{{ url('/') }}" class="btn btn-secondary">{{ __('auth.back_to_home') }}</a>
            </div>

            @if (session('status'))
                <div class="auth-status">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="auth-error">
                    <p>{{ __('auth.main.check_from_data') }}:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card auth-card">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
