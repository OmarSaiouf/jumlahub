@extends('layouts.site')

@section('title', 'JumlaHub | ' . ($product->name ?? 'تفاصيل المنتج'))

@php
    $quantityPlaceholder = $availableQuantity > 0 ? 'أدخل الكمية المطلوبة' : 'غير متاح للطلب حالياً';
    $canOrder = $isOpen && $availableQuantity > 0 && $paymentProviders->count() > 0;
@endphp

@section('content')
    <main class="container product-details">
        <div class="card">
            <div class="product-header">
                <img src="{{ $product->image ?? asset('images/iconsProduct.png') }}" alt="{{ $product->name }}"
                    class="product-image-large" loading="lazy">

                <div class="product-info">
                    <span class="eyebrow" style="margin-bottom: 6px;">
                        <i class="fas fa-bolt"></i>
                        عرض نشط
                    </span>

                    <div class="hero-actions" style="margin: 0 0 10px; flex-wrap: wrap; gap: 8px;">
                        @if ($product->category?->name)
                            <span class="chip">
                                <i class="fas fa-layer-group"></i>
                                {{ $product->category->name }}
                            </span>
                        @endif
                        @if ($product->discount)
                            <span class="pill">
                                <i class="fas fa-percentage"></i>
                                خصم: {{ $product->discount }}%
                            </span>
                        @endif
                    </div>

                    <h1>{{ $product->name }}</h1>
                    <div class="product-price-large">
                        {{ number_format((float) ($product->price ?? 0), 2) }}
                        <span>/ {{ $product->unit ?? 'وحدة' }}</span>
                    </div>

                    <span class="status-badge {{ $isOpen ? 'status-open' : 'status-completed' }}">
                        <i class="fas fa-circle"></i>
                        {{ $isOpen ? 'متاح للطلب' : 'اكتمل الطلب' }}
                    </span>

                    <div class="progress-section">
                        <div class="progress-bar progress-large">
                            <div class="progress-fill" style="width: {{ $progressPercent }}%;"></div>
                        </div>
                        <div class="progress-stats">
                            <span><i class="fas fa-bullseye"></i> الكمية المستهدفة:
                                <strong>{{ number_format($product->quantity ?? 0) }}</strong></span>
                            <span><i class="fas fa-check-circle"></i> تم بيع:
                                <strong>{{ number_format($product->quantity_sold ?? 0) }}</strong></span>
                            <span><i class="fas fa-hourglass-half"></i> المتبقي:
                                <strong>{{ number_format($availableQuantity) }}</strong></span>
                        </div>
                    </div>

                    <div class="stock-stats">
                        <span><i class="fas fa-warehouse"></i> الحد الأدنى للطلب:
                            {{ $availableQuantity > 0 ? 1 : 0 }} وحدة</span>
                        <span><i class="fas fa-truck"></i> الشحن المتوقع: 5-7 أيام عمل.</span>
                    </div>
                </div>
            </div>

            <div class="product-description">
                <h3 style="margin-bottom: 10px;">
                    <i class="fas fa-info-circle"></i>
                    نبذة عن المنتج
                </h3>
                <p>
                    {{ $product->description ?: 'لم تتم إضافة وصف بعد لهذا المنتج. تواصل معنا لمعرفة التفاصيل أو راجع المواصفات المتاحة أعلاه.' }}
                </p>
            </div>

            <div class="order-section">
                <h3 style="margin-bottom: 12px;">
                    <i class="fas fa-shopping-cart"></i>
                    قدّم طلب شراء
                </h3>

                @unless ($canOrder)
                    <div class="alert">
                        <i class="fas fa-ban"></i>
                        هذا المنتج غير متاح للطلب حالياً بسبب اكتمال الكمية أو إيقافه.
                    </div>
                @endunless

                @guest
                    <div class="alert">
                        <i class="fas fa-circle-info"></i>
                        يرجى تسجيل الدخول لإرسال طلب شراء وتأكيد الكمية.
                    </div>
                @endguest

                <form method="POST" action="{{ route('create.order') }}" class="create-order">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="modal-grid">
                        <div class="form-group">
                            <label class="form-label" for="quantity">الكمية المطلوبة</label>
                            <input id="quantity" type="number" name="quantity" class="order-input" min="1"
                                max="{{ $availableQuantity }}" value="{{ $canOrder ? 1 : 0 }}"
                                placeholder="{{ $quantityPlaceholder }}" {{ $canOrder ? '' : 'disabled' }}
                                data-order-quantity>
                            <div class="help-text">تأكد من أن الكمية المدخلة ضمن الحد المتاح.</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="payment_provider_id">اختر مزود الدفع</label>
                            <select id="payment_provider_id" name="payment_provider_id" class="order-input"
                                {{ $canOrder ? '' : 'disabled' }} required>
                                <option value="">اختر مزود الدفع</option>
                                @forelse ($paymentProviders as $provider)
                                    <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @empty
                                    <option value="" disabled>لا توجد وسائل دفع متاحة حالياً</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="order-total">
                        <div>
                            <span class="muted">إجمالي الطلب المتوقع</span>
                            <div class="total-number" data-order-total>
                                0.00
                            </div>
                        </div>
                        <div class="pill">
                            <i class="fas fa-shield-check"></i>
                            عملية دفع آمنة وبياناتك مشفرة بالكامل.
                        </div>
                    </div>

                    <div class="hero-actions" style="margin-top: 4px; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary" {{ $canOrder ? '' : 'disabled' }}>
                            <i class="fas fa-paper-plane"></i>
                            إرسال الطلب
                        </button>
                        <a href="{{ url('/orders') }}" class="btn btn-ghost">
                            <i class="fas fa-list-check"></i>
                            عرض الطلبات
                        </a>
                    </div>
                </form>
            </div>

            <div class="user-orders">
                <p><i class="fas fa-history"></i> لديك <strong>{{ $userOrdersCount }}</strong> طلب/طلبات سابقة على
                    هذا المنتج.</p>
            </div>
        </div>
    </main>

    <script>
        (() => {
            const quantityInput = document.querySelector('[data-order-quantity]');
            const totalEl = document.querySelector('[data-order-total]');
            const unitPrice = {{ number_format((float) ($product->price ?? 0), 2, '.', '') }};
            const available = {{ $availableQuantity }};
            const canOrder = {{ $canOrder ? 'true' : 'false' }};

            if (!quantityInput || !totalEl) {
                return;
            }

            const formatAmount = (value) =>
                value.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

            const sync = () => {
                if (!canOrder) {
                    totalEl.textContent = formatAmount(0);
                    return;
                }

                const raw = Number(quantityInput.value);
                const qty = Number.isFinite(raw) ? Math.max(1, Math.min(raw, available || 1)) : 1;

                quantityInput.value = qty;
                totalEl.textContent = formatAmount(qty * unitPrice);
            };

            quantityInput.addEventListener('input', sync);
            sync();
        })();
    </script>
@endsection
