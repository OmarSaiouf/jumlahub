<!DOCTYPE html>
<html lang="ar" dir="rtl">
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
                <img class="logo-img" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'JumlaHub') }} logo" loading="lazy">
            </div>
            <div class="chip">شبكة موردين موثوقة</div>

            <h2>ادخل إلى لوحة التحكم وابدأ الشراء بالجملة</h2>
            <p>انضم إلى JumlaHub لتتابع طلباتك، تتفاوض مع موردين موثقين، وتحصل على أفضل أسعار الجملة مع دعم عربي مباشر.</p>

            <ul class="feature-list">
                <li><span class="pill">توريد مستقر</span>عقود توريد واضحة وجداول تسليم ثابتة لتأمين مخزون متجرك.</li>
                <li><span class="pill">تقارير فورية</span>متابعة حالة الطلبات والشحنات في الوقت الحقيقي مع تنبيهات ذكية.</li>
                <li><span class="pill">دعم سريع</span>فريق دعم عربي يساعدك في أي استفسار أو تنسيق لوجستي.</li>
            </ul>

            <div class="auth-stats">
                <div class="stat-card">
                    <span class="stat-number">+320</span>
                    <span class="stat-label">مورّد موثق في JumlaHub</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">92%</span>
                    <span class="stat-label">معدل رضا التجار</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">24/7</span>
                    <span class="stat-label">دعم وتشغيل مستمر</span>
                </div>
            </div>

            @isset($cta)
                <div class="auth-cta">{{ $cta }}</div>
            @endisset
        </aside>

        <main class="auth-main">
            <div class="section-head">
                <div>
                    <div class="eyebrow">أهلاً بك في JumlaHub</div>
                    <h1 class="section-title">{{ $title ?? 'تسجيل الدخول' }}</h1>
                    @isset($subtitle)
                        <p class="auth-subtitle">{{ $subtitle }}</p>
                    @endisset
                </div>
                <a href="{{ url('/') }}" class="btn btn-secondary">العودة للرئيسية</a>
            </div>

            @if (session('status'))
                <div class="auth-status">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="auth-error">
                    <p>تأكد من البيانات التالية:</p>
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
