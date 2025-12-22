@extends('layouts.site')

@php
    $stats = [
        ['value' => '250+', 'label' => 'صفقات توريد سنوية مكتملة'],
        ['value' => '48 ساعة', 'label' => 'متوسط سرعة تجهيز الشحنات'],
        ['value' => '4.8 / 5', 'label' => 'تقييم رضا التجار والموردين'],
    ];

@endphp

@section('title', 'JumlaHub | منصة الجملة الذكية للتجار والموردين')

@section('content')
    <div class="container">
        <section class="hero">
            <div>
                <span class="eyebrow">
                    <i class="fas fa-signal"></i>
                    منصة جملة جاهزة
                </span>
                <h1>منصة الجملة الذكية لشراء كميات كبيرة بثقة وسهولة</h1>
                <p>نربط الموردين بالمتاجر لتأمين الكميات الكبيرة بأفضل الأسعار، مع شحن سريع، متابعة واضحة، ودعم متواصل
                    حتى استلام الطلب.</p>
                <div class="hero-actions">
                    <a href="#products" class="btn btn-primary">
                        <i class="fas fa-boxes-stacked"></i>
                        استعرض المنتجات
                    </a>
                    @if (!Auth::check())
                        <a href="{{ route('register') }}" class="btn btn-secondary">
                            <i class="fas fa-user-plus"></i>
                            تسجيل
                        </a>
                    @endif
                    @if (Auth::check())
                        <a href="{{ url('/orders') }}" class="btn btn-ghost">
                            <i class="fas fa-list-check"></i>
                            تتبع الطلبات
                        </a>
                    @endif
                </div>
                <ul class="feature-list">
                    <li><i class="fas fa-shield-check"></i> توثيق الموردين وضمان الجودة قبل اعتمادهم</li>
                    <li><i class="fas fa-truck-fast"></i> شحن منظم ومواعيد تسليم محددة سلفاً</li>
                    <li><i class="fas fa-circle-nodes"></i> إدارة عروض وأسعار محدثة لحظياً</li>
                </ul>
            </div>

            <div class="card">
                <div class="section-head" style="margin-bottom: 12px;">
                    <div>
                        <div class="eyebrow">لوحة سريعة</div>
                        <h2 class="section-title" style="font-size: 22px;">أرقام اليوم في JumlaHub</h2>
                    </div>
                </div>
                <div class="hero-stats">
                    @foreach ($stats as $stat)
                        <div class="stat-card">
                            <span class="stat-number">{{ $stat['value'] }}</span>
                            <span class="stat-label">{{ $stat['label'] }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="feature-list" style="margin-top: 12px;">
                    <li><i class="fas fa-clock-rotate-left"></i> متابعات في الوقت الفعلي لحالة الشحنات.</li>
                    <li><i class="fas fa-headset"></i> دعم عربي مباشر للتنسيق مع الموردين.</li>
                </div>
            </div>
        </section>

        <section class="toolbar">
            <form method="GET" class="search">
                <input type="search" name="q" value="{{ request('q') }}"
                    placeholder="ابحث حسب اسم المنتج أو التصنيف..." aria-label="بحث عام">
                <i class="fas fa-search"></i>
            </form>
            <select name="status">
                <option value="">كل الحالات</option>
                @foreach ($filterStatuses as $key => $value)
                    <option value="{{ $key }}" @selected(request('status') === $key)>{{ $value }}</option>
                @endforeach

            </select>

            <select name="sort" aria-label="ترتيب حسب الأحدث">
                <option value="">ترتيب افتراضي</option>
                @foreach ($filterSorts as $key => $value)
                    <option value="{{ $key }}" @selected(request('sort') === $key)>{{ $value }}</option>
                @endforeach

            </select>
        </section>

        <section id="categories" class="categories-section">
            <div class="section-head">
                <div>
                    <div class="eyebrow">الفئات</div>
                    <h2 class="section-title">تصفح فئات الجملة الأكثر حركة</h2>
                    <p class="muted">جهز مخزونك من الفئات التي تناسب نشاطك التجاري مع عروض محدثة باستمرار.</p>
                </div>
                <div class="chip">
                    <i class="fas fa-bolt"></i>
                    يتم تحديث الأسعار يومياً
                </div>
            </div>

            <div class="categories-grid">
                @foreach ($categories as $category)
                    <x-category :category="$category"></x-category>
                @endforeach
            </div>
        </section>

        <section id="products" class="featured-section">
            <div class="section-head">
                <div>
                    <div class="eyebrow">عروض مختارة</div>
                    <h2 class="section-title">منتجات جاهزة للطلب بالجملة</h2>
                    <p class="muted">اختيارات تم فحصها لضمان الجودة وسهولة الشحن إلى متجرك.</p>
                </div>
                <a href="{{ url('/orders') }}" class="btn btn-secondary">
                    <i class="fas fa-receipt"></i>
                    إدارة طلباتي
                </a>
            </div>

            <div class="product-grid">
                @foreach ($products as $product)
                    <x-product :product="$product"></x-product>
                    <x-create-order :product="$product" :paymentProviders="$paymentProviders"></x-create-order>
                @endforeach
            </div>
        </section>
    </div>
@endsection
