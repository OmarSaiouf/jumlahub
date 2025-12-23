@extends('layouts.site')

@section('title', __('pages.product.title_template', ['name' => $product->name ?? __('pages.product.about_title')]))

@php
    $quantityPlaceholder = $availableQuantity > 0 ? __('pages.product.quantity_placeholder') : __('pages.product.not_available');
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
                        {{ __('pages.product.active_badge') }}
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
                                {{ __('pages.product.discount') }}: {{ $product->discount }}%
                            </span>
                        @endif
                    </div>

                    <h1>{{ $product->name }}</h1>
                    <div class="product-price-large">
                        {{ number_format((float) ($product->price ?? 0), 2) }}
                          <span>/ {{ $product->unit ?? __('components.create_order.unit') }}</span>
                    </div>

                    <span class="status-badge {{ $isOpen ? 'status-open' : 'status-completed' }}">
                        <i class="fas fa-circle"></i>
                        {{ $isOpen ? __('pages.product.status_open') : __('pages.product.status_completed') }}
                    </span>

                    <div class="progress-section">
                        <div class="progress-bar progress-large">
                            <div class="progress-fill" style="width: {{ $progressPercent }}%;"></div>
                        </div>
                        <div class="progress-stats">
                                <span><i class="fas fa-bullseye"></i> {{ __('pages.product.target_quantity') }}:
                                    <strong>{{ number_format($product->quantity ?? 0) }}</strong></span>
                                <span><i class="fas fa-check-circle"></i> {{ __('pages.product.sold') }}:
                                    <strong>{{ number_format($product->quantity_sold ?? 0) }}</strong></span>
                                <span><i class="fas fa-hourglass-half"></i> {{ __('pages.product.remaining') }}:
                                    <strong>{{ number_format($availableQuantity) }}</strong></span>
                        </div>
                    </div>

                    <div class="stock-stats">
                            <span><i class="fas fa-warehouse"></i> {{ __('components.product.min_order') }}:
                                {{ $availableQuantity > 0 ? 1 : 0 }} {{ __('components.create_order.unit') }}</span>
                            <span><i class="fas fa-truck"></i> {{ __('pages.product.shipping_expected') }}</span>
                    </div>
                </div>
            </div>

            <div class="product-description">
                <h3 style="margin-bottom: 10px;">
                    <i class="fas fa-info-circle"></i>
                    {{ __('pages.product.about_title') }}
                </h3>
                <p>
                    {{ $product->description ?: __('pages.product.description_fallback') }}
                </p>
            </div>

            <div class="order-section">
                <h3 style="margin-bottom: 12px;">
                    <i class="fas fa-shopping-cart"></i>
                    {{ __('pages.product.order_title') }}
                </h3>

                @unless ($canOrder)
                    <div class="alert">
                        <i class="fas fa-ban"></i>
                        {{ __('pages.product.not_available') }}
                    </div>
                @endunless

                @guest
                    <div class="alert">
                        <i class="fas fa-circle-info"></i>
                        {{ __('pages.product.guest_note') }}
                    </div>
                @endguest

                <form method="POST" action="{{ route('main.create.order') }}" class="create-order">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div class="modal-grid">
                        <div class="form-group">
                            <label class="form-label" for="quantity">{{ __('pages.product.quantity_label') }}</label>
                            <input id="quantity" type="number" name="quantity" class="order-input" min="1"
                                max="{{ $availableQuantity }}" value="{{ $canOrder ? 1 : 0 }}"
                                placeholder="{{ $quantityPlaceholder }}" {{ $canOrder ? '' : 'disabled' }}
                                data-order-quantity>
                            <div class="help-text">{{ __('pages.product.quantity_label') }} — {{ __('pages.product.quantity_placeholder') }}</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="payment_provider_id">{{ __('pages.product.choose_provider') }}</label>
                            <select id="payment_provider_id" name="payment_provider_id" class="order-input"
                                {{ $canOrder ? '' : 'disabled' }} required>
                                <option value="">{{ __('pages.product.choose_provider') }}</option>
                                @forelse ($paymentProviders as $provider)
                                    <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @empty
                                    <option value="" disabled>{{ __('pages.product.no_providers') }}</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="order-total">
                        <div>
                            <span class="muted">{{ __('pages.product.order_total_label') }}</span>
                            <div class="total-number" data-order-total>
                                0.00
                            </div>
                        </div>
                        <div class="pill">
                            <i class="fas fa-shield-check"></i>
                            {{ __('pages.product.secure_payment_note') }}
                        </div>
                    </div>

                    <div class="hero-actions" style="margin-top: 4px; justify-content: flex-end;">
                        <x-share :id="$product->id" class="btn btn-primary" />
                            
                        <button type="submit" class="btn btn-primary" {{ $canOrder ? '' : 'disabled' }}>
                            <i class="fas fa-paper-plane"></i>
                            {{ __('pages.product.send_order') }}
                        </button>
                        <a href="{{ url('/orders') }}" class="btn btn-ghost">
                            <i class="fas fa-list-check"></i>
                            {{ __('pages.product.view_orders') }}
                        </a>
                    </div>
                </form>

            </div>

            <div class="user-orders">
                <p><i class="fas fa-history"></i> {{ __('pages.product.user_orders_count', ['count' => $userOrdersCount]) }}</p>
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
