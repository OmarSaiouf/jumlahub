@extends('layouts.site')

@php
    $stats = [
        ['value' => '250+', 'label' => __('home.stats.completed_supplies')],
        ['value' => __('home.stats.avg_packing_time_value'), 'label' => __('home.stats.avg_packing_time')],
        ['value' => '4.8 / 5', 'label' => __('home.stats.seller_rating')],
    ];

@endphp

@section('title', __('home.title'))

@section('content')
    <div class="container">
        <section class="hero">
            <div>
                <span class="eyebrow">
                    <i class="fas fa-signal"></i>
                    {{ __('home.eyebrow.ready_platform') }}
                </span>
                <h1>{{ __('home.hero.title') }}</h1>
                <p>{{ __('home.hero.description') }}</p>
                <div class="hero-actions">
                    <a href="#products" class="btn btn-primary">
                        <i class="fas fa-boxes-stacked"></i>
                        {{ __('home.actions.browse_products') }}
                    </a>
                    @if (!Auth::check())
                        <a href="{{ route('register') }}" class="btn btn-secondary">
                            <i class="fas fa-user-plus"></i>
                            {{ __('home.actions.register') }}
                        </a>
                    @endif
                    @if (Auth::check())
                        <a href="{{ url('/orders') }}" class="btn btn-ghost">
                            <i class="fas fa-list-check"></i>
                            {{ __('home.actions.track_orders') }}
                        </a>
                    @endif
                </div>
                <ul class="feature-list">
                    <li><i class="fas fa-shield-check"></i> {{ __('home.features.quality_vet') }}</li>
                    <li><i class="fas fa-truck-fast"></i> {{ __('home.features.organized_shipping') }}</li>
                    <li><i class="fas fa-circle-nodes"></i> {{ __('home.features.live_pricing') }}</li>
                </ul>
            </div>

            <div class="card">
                <div class="section-head" style="margin-bottom: 12px;">
                    <div>
                        <div class="eyebrow">{{ __('home.quick_panel') }}</div>
                        <h2 class="section-title" style="font-size: 22px;">{{ __('home.today_numbers') }}</h2>
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
                    <li><i class="fas fa-clock-rotate-left"></i> {{ __('home.card_features.live_tracking') }}</li>
                    <li><i class="fas fa-headset"></i> {{ __('home.card_features.arabic_support') }}</li>
                </div>
            </div>
        </section>

        <section class="toolbar">
            <form method="GET" class="search">
                <input type="search" name="q" value="{{ request('q') }}"
                    placeholder="{{ __('home.search_placeholder') }}" aria-label="{{ __('home.search_aria') }}">
                <i class="fas fa-search"></i>
            </form>
            <select name="status">
                <option value="">{{ __('home.filters.all_statuses') }}</option>
                @foreach ($filterStatuses as $key => $value)
                    <option value="{{ $key }}" @selected(request('status') === $key)>{{ $value }}</option>
                @endforeach

            </select>

            <select name="sort" aria-label="{{ __('home.sort.aria') }}">
                <option value="">{{ __('home.sort.default') }}</option>
                @foreach ($filterSorts as $key => $value)
                    <option value="{{ $key }}" @selected(request('sort') === $key)>{{ $value }}</option>
                @endforeach

            </select>
        </section>

        <section id="categories" class="categories-section">
            <div class="section-head">
                <div>
                    <div class="eyebrow">{{ __('home.categories.eyebrow') }}</div>
                    <h2 class="section-title">{{ __('home.categories.title') }}</h2>
                    <p class="muted">{{ __('home.categories.muted') }}</p>
                </div>
                <div class="chip">
                    <i class="fas fa-bolt"></i>
                    {{ __('home.categories.chip') }}
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
                    <div class="eyebrow">{{ __('home.featured.eyebrow') }}</div>
                    <h2 class="section-title">{{ __('home.featured.title') }}</h2>
                    <p class="muted">{{ __('home.featured.muted') }}</p>
                </div>
                <a href="{{ url('/orders') }}" class="btn btn-secondary">
                    <i class="fas fa-receipt"></i>
                    {{ __('home.featured.manage_orders') }}
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
