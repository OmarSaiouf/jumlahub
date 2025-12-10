@extends('layouts.site')

@php
    $stats = [
        ['value' => '250+', 'label' => 'صفقات توريد سنوية مكتملة'],
        ['value' => '48 ساعة', 'label' => 'متوسط سرعة تجهيز الشحنات'],
        ['value' => '4.8 / 5', 'label' => 'تقييم رضا التجار والموردين'],
    ];

    $categories = [
        ['icon' => 'fa-microchip', 'name' => 'إلكترونيات وإكسسوارات', 'desc' => 'شواحن، بطاريات، وحدات تخزين'],
        ['icon' => 'fa-shirt', 'name' => 'أزياء وملابس', 'desc' => 'ملابس عملية وجاهزة للشحن'],
        ['icon' => 'fa-couch', 'name' => 'أثاث وتجهيزات', 'desc' => 'أثاث مكتبي ومنزلي'],
        ['icon' => 'fa-bottle-water', 'name' => 'منتجات استهلاكية', 'desc' => 'مياه، أغذية مغلفة، منظفات'],
        ['icon' => 'fa-screwdriver-wrench', 'name' => 'معدات وأدوات', 'desc' => 'عدد وأدوات صيانة احترافية'],
        ['icon' => 'fa-basket-shopping', 'name' => 'سوبرماركت', 'desc' => 'عروض الجملة للمتاجر الصغيرة'],
    ];

    $products = [
        [
            'name' => 'باور بانك 30000mAh بخلايا LG',
            'price' => '2.5',
            'unit' => 'ريال / قطعة',
            'progress' => 62,
            'sold' => 620,
            'stock' => 380,
            'badge' => 'جاهز للشحن',
            'tag' => 'إلكترونيات',
            'image' => 'https://images.unsplash.com/photo-1592118794073-ae5d5e0a9f6c?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'name' => 'ذاكرة USB سريعة 32GB',
            'price' => '8',
            'unit' => 'ريال / قطعة',
            'progress' => 38,
            'sold' => 190,
            'stock' => 310,
            'badge' => 'توريد أسبوعي',
            'tag' => 'تجهيز مكتبي',
            'image' => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'name' => 'مقاعد انتظار معدنية 3 مقاعد',
            'price' => '15',
            'unit' => 'ريال / قطعة',
            'progress' => 80,
            'sold' => 400,
            'stock' => 100,
            'badge' => 'عرض محدود',
            'tag' => 'أثاث وتجهيزات',
            'image' => 'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'name' => 'شاحن جداري USB-C بقدرة 30W',
            'price' => '5',
            'unit' => 'ريال / قطعة',
            'progress' => 45,
            'sold' => 225,
            'stock' => 275,
            'badge' => 'مصنع موثوق',
            'tag' => 'إلكترونيات',
            'image' => 'https://images.unsplash.com/photo-1586953208448-b95a79798f07?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'name' => 'كيبلات شحن USB-C معتمدة',
            'price' => '3',
            'unit' => 'ريال / قطعة',
            'progress' => 90,
            'sold' => 450,
            'stock' => 50,
            'badge' => 'ضمان 12 شهر',
            'tag' => 'إكسسوارات',
            'image' => 'https://images.unsplash.com/photo-1526374965328-7f61d4dc18c5?auto=format&fit=crop&w=800&q=80',
        ],
        [
            'name' => 'طقم أدوات صيانة متعدد الاستعمال',
            'price' => '7',
            'unit' => 'ريال / قطعة',
            'progress' => 25,
            'sold' => 125,
            'stock' => 375,
            'badge' => 'متاح للحجز',
            'tag' => 'معدات وأدوات',
            'image' => 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=800&q=80',
        ],
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
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-secondary">
                            <i class="fas fa-user-plus"></i>
                            ابدأ كتاجر جديد
                        </a>
                    @endif
                    <a href="{{ url('/orders') }}" class="btn btn-ghost">
                        <i class="fas fa-list-check"></i>
                        تتبع الطلبات
                    </a>
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
            <form action="{{ url('/products') }}" method="GET" class="search">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="ابحث حسب اسم المنتج أو التصنيف..."
                       aria-label="بحث عام">
                <i class="fas fa-search"></i>
            </form>
            <select name="status" aria-label="تصفية حسب الحالة">
                <option value="">كل الحالات</option>
                <option value="ready">جاهز للشحن</option>
                <option value="open">متاح للحجز</option>
                <option value="limited">عرض محدود</option>
            </select>
            <select name="sort" aria-label="ترتيب حسب الأحدث">
                <option value="recent">الأحدث أولاً</option>
                <option value="popular">الأكثر طلباً</option>
                <option value="price-asc">السعر من الأقل للأعلى</option>
                <option value="price-desc">السعر من الأعلى للأقل</option>
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
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="fas {{ $category['icon'] }}"></i>
                        </div>
                        <h3>{{ $category['name'] }}</h3>
                        <p>{{ $category['desc'] }}</p>
                    </div>
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
                    <div class="card product-card">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="product-image">
                        <div class="product-body">
                            <div class="hero-actions" style="margin: 0 0 8px;">
                                <span class="pill">{{ $product['badge'] }}</span>
                                <span class="chip">{{ $product['tag'] }}</span>
                            </div>
                            <h3 class="product-name">{{ $product['name'] }}</h3>
                            <div class="product-price">
                                {{ $product['price'] }}
                                <span>{{ $product['unit'] }}</span>
                            </div>

                            <div class="progress-container">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $product['progress'] }}%;"></div>
                                </div>
                                <div class="progress-text">
                                    <span>{{ $product['sold'] }} مباعة</span>
                                    <span>{{ $product['stock'] }} متبقية</span>
                                </div>
                            </div>

                            <div class="stock-stats">
                                <span><i class="fas fa-warehouse"></i> حد أدنى للطلب: 100 قطعة</span>
                                <span><i class="fas fa-truck"></i> تسليم خلال 5-7 أيام</span>
                            </div>

                            <div class="hero-actions" style="margin-top: 12px;">
                                <a href="{{ url('/orders') }}" class="btn btn-primary">
                                    <i class="fas fa-cart-plus"></i>
                                    اطلب الآن
                                </a>
                                @if (Route::has('login'))
                                    <a href="{{ route('login') }}" class="btn btn-ghost">
                                        <i class="fas fa-eye"></i>
                                        تفاصيل إضافية
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
