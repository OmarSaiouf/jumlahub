@extends('layouts.site')

@section('title', 'إتمام الدفع | JumlaHub')

@php
    use App\Core\Enums\OrderStatus;

    $statusLabels = [
        OrderStatus::PENDING->getValue() => 'الطلب بالطريق',
        OrderStatus::PROCESSING->getValue() => 'بانتظار الدفع',
        OrderStatus::COMPLETED->getValue() => 'تم التسليم',
        OrderStatus::CANCELLED->getValue() => 'تم الإلغاء',
        OrderStatus::REFUNDED->getValue() => 'تم الاسترداد',
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
    $provider = $order->paymentProvider->name ?? 'مزود الدفع';
    $currency = $order->product->currency->code ?? '';
@endphp

@section('content')
    <main class="container payment-page">
        <div class="section-head">
            <h1 class="section-title"><i class="fas fa-credit-card"></i> إتمام الدفع</h1>
            <span class="muted">راجع بيانات الطلب ثم أكمل الدفع عبر {{ $provider }}.</span>
        </div>

        <div class="card grid gap-4 md:grid-cols-[1.3fr,1fr] items-start">
            <div class="flex flex-col gap-3">
                <div class="flex flex-wrap items-center gap-3 justify-between">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="chip"><i class="fas fa-hashtag"></i> الطلب {{ $order->id }}</span>
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
                                الكمية: {{ $order->quantity }}</span>
                            <span class="inline-flex items-center gap-1"><i class="fas fa-wallet text-primary"></i>
                                قيمة الطلب: {{ number_format($order->amount, 2) }} {{ $currency }}</span>
                            <span class="inline-flex items-center gap-1"><i class="fas fa-calendar-alt text-primary"></i>
                                تاريخ الطلب:
                                {{ optional($order->created_at)->format('Y-m-d') ?? $order->created_at }}</span>
                        </div>
                    </div>
                </div>

                <div class="info-banner">
                    <i class="fas fa-info-circle"></i>
                    الرجاء التأكد من صحة البيانات قبل إتمام الدفع. يمكن العودة لصفحة الطلب من زر تفاصيل الطلب.
                </div>
            </div>

            <div
                class="card bg-gradient-to-br from-emerald-50 via-white to-amber-50 border border-slate-200 rounded-2xl shadow-sm">
                <div class="flex flex-col gap-3">
                    <div class="flex items-center justify-between gap-2">
                        <div class="text-sm font-bold text-slate-900">طريقة الدفع</div>
                        <span class="chip"><i class="fas fa-shield-alt"></i> عملية آمنة</span>
                    </div>

                    <div class="grid gap-2 text-sm text-slate-700">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-building-columns text-primary"></i>
                            <span>المزود: {{ $provider }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-receipt text-primary"></i>
                            <span>إجمالي مستحق: {{ number_format($order->amount, 2) }} {{ $currency }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-truck text-primary"></i>
                            <span>حالة الطلب: {{ $statusText }}</span>
                        </div>
                    </div>

                    <div class="border border-dashed border-emerald-200 rounded-xl p-3 flex flex-col gap-2 bg-white">
                        <div class="flex items-center gap-2 text-slate-800 font-semibold">
                            <i class="fas fa-play-circle text-primary"></i> خطوات الدفع
                        </div>
                        <ol class="list-decimal pe-4 text-slate-700 text-sm space-y-1">
                            <li>تأكد من إجمالي الطلب والمزود.</li>
                            <li>اضغط زر إتمام الدفع للانتقال للبوابة.</li>
                            <li>أكمل العملية ثم عد لتتبع الطلب.</li>
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
                                إتمام الدفع الآن
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
