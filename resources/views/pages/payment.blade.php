@extends('layouts.site')

@section('title', __('pages.payment.title'))

@php
    use App\Core\Enums\OrderStatus;

    $statusLabels = [
        OrderStatus::PENDING->getValue() => __('components.order.status.pending'),
        OrderStatus::PROCESSING->getValue() => __('components.order.status.processing'),
        OrderStatus::COMPLETED->getValue() => __('components.order.status.completed'),
        OrderStatus::CANCELLED->getValue() => __('components.order.status.cancelled'),
        OrderStatus::REFUNDED->getValue() => __('components.order.status.refunded'),
    ];

    $statusColors = [
        OrderStatus::PENDING->getValue() => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        OrderStatus::PROCESSING->getValue() => 'bg-amber-50 text-amber-700 border border-amber-200',
        OrderStatus::COMPLETED->getValue() => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        OrderStatus::CANCELLED->getValue() => 'bg-rose-50 text-rose-700 border border-rose-200',
        OrderStatus::REFUNDED->getValue() => 'bg-blue-50 text-blue-700 border border-blue-200',
    ];

    $status = $order->status;
    $statusText = $statusLabels[$status] ?? $status;
    $statusClass = $statusColors[$status] ?? 'bg-slate-50 text-slate-700 border border-slate-200';
    $provider = $order->paymentProvider->name ?? __('pages.payment.provider_label');
    $currency = $order->product->currency->code ?? '';
@endphp

@section('content')
    <main class="container payment-page">
        <div class="section-head">
            <h1 class="section-title"><i class="fas fa-credit-card"></i> {{ __('pages.payment.title_short') }}</h1>
            <span class="muted">{{ __('pages.payment.review_via', ['provider' => $provider]) }}</span>
        </div>

        <div class="card grid gap-4 md:grid-cols-[1.3fr,1fr] items-start">
            <div class="flex flex-col gap-3">
                <div class="flex flex-wrap items-center gap-3 justify-between">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="chip"><i class="fas fa-hashtag"></i> {{ __('pages.payment.order_label', ['id' => $order->id]) }}</span>
                        <span class="chip {{ $statusClass }}">
                            <i class="fas fa-circle"></i> {{ $statusText }}
                        </span>
                    </div>
                    <span class="chip"><i class="fas fa-building-columns"></i> {{ $provider }}</span>
                </div>

                <div class="order-summary grid gap-3 md:grid-cols-[auto,1fr] items-center">
                    <img src="{{ $order->product->image ?? asset('images/iconsProduct.png') }}"
                        alt="{{ $order->product->name }}"
                        class="rounded-xl w-28 h-28 object-contain border border-slate-200 bg-white shadow-sm">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-lg font-bold text-slate-900">{{ $order->product->name }}</h3>
                        <div class="flex flex-wrap gap-3 text-sm text-slate-600">
                            <span class="inline-flex items-center gap-1"><i class="fas fa-cubes text-primary"></i>
                                {{ __('components.order.copy.quantity') }} {{ $order->quantity }}</span>
                            <span class="inline-flex items-center gap-1"><i class="fas fa-wallet text-primary"></i>
                                {{ __('components.order.copy.amount') }} {{ number_format($order->amount, 2) }} {{ $currency }}</span>
                            <span class="inline-flex items-center gap-1"><i class="fas fa-calendar-alt text-primary"></i>
                                {{ __('components.order.copy.date') }}
                                {{ optional($order->created_at)->format('Y-m-d') ?? $order->created_at }}</span>
                        </div>
                    </div>
                </div>

                <div class="info-banner">
                    <i class="fas fa-info-circle"></i>
                    {{ __('pages.payment.info_banner') }}
                </div>
            </div>

            <div
                class="card bg-gradient-to-br from-emerald-50 via-white to-amber-50 border border-slate-200 rounded-2xl shadow-sm">
                <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between gap-2">
                            <div class="text-sm font-bold text-slate-900">{{ __('pages.payment.method_title') }}</div>
                            <span class="chip"><i class="fas fa-shield-alt"></i> {{ __('pages.payment.secure') }}</span>
                        </div>

                    <div class="grid gap-2 text-sm text-slate-700">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-building-columns text-primary"></i>
                            <span>{{ __('pages.payment.provider_label') }}: {{ $provider }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-receipt text-primary"></i>
                            <span>{{ __('pages.payment.amount_due') }}: {{ number_format($order->amount, 2) }} {{ $currency }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-truck text-primary"></i>
                            <span>{{ __('pages.payment.order_status') }}: {{ $statusText }}</span>
                        </div>
                    </div>

                    <div class="border border-dashed border-emerald-200 rounded-xl p-3 flex flex-col gap-2 bg-white">
                        <div class="flex items-center gap-2 text-slate-800 font-semibold">
                            <i class="fas fa-play-circle text-primary"></i> {{ __('pages.payment.steps_title') }}
                        </div>
                        <ol class="list-decimal pe-4 text-slate-700 text-sm space-y-1">
                            <li>{{ __('pages.payment.steps.check') }}</li>
                            <li>{{ __('pages.payment.steps.click') }}</li>
                            <li>{{ __('pages.payment.steps.complete') }}</li>
                        </ol>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        {{-- <a href="#" class="btn btn-primary w-full justify-center md:w-auto">
                            
                        </a> --}}
                        <form action="{{ route('payment.pay') }}" method="post">

                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <button type="submit" class="btn btn-primary w-full justify-center md:w-auto">
                                <i class="fas fa-arrow-left"></i>
                                {{ __('pages.payment.pay_now') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
