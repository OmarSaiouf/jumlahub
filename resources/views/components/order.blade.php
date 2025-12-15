@php
    use App\Core\Enums\OrderStatus;

    $statusLabels = [
        OrderStatus::PENDING->getValue() => 'الطلب بالطريق',
        OrderStatus::PROCESSING->getValue() => 'بانتظار الدفع',
        OrderStatus::COMPLETED->getValue() => 'تم التسليم',
        OrderStatus::CANCELLED->getValue() => 'تم الإلغاء',
        OrderStatus::REFUNDED->getValue() => 'تم الاسترداد',
    ];

    $statusClasses = [
        OrderStatus::PENDING->getValue() => 'status-pending',
        OrderStatus::PROCESSING->getValue() => 'status-processing',
        OrderStatus::COMPLETED->getValue() => 'status-completed',
        OrderStatus::CANCELLED->getValue() => 'status-cancelled',
        OrderStatus::REFUNDED->getValue() => 'status-refunded',
    ];

    $statusIcons = [
        OrderStatus::PENDING->getValue() => 'fa-truck-fast',
        OrderStatus::PROCESSING->getValue() => 'fa-wallet',
        OrderStatus::COMPLETED->getValue() => 'fa-circle-check',
        OrderStatus::CANCELLED->getValue() => 'fa-ban',
        OrderStatus::REFUNDED->getValue() => 'fa-rotate-left',
    ];

    $statePalette = [
        OrderStatus::PENDING->getValue() => 'border border-emerald-200 bg-emerald-50 text-emerald-700',
        OrderStatus::PROCESSING->getValue() => 'border border-amber-200 bg-amber-50 text-amber-700',
        OrderStatus::COMPLETED->getValue() => 'border border-emerald-200 bg-emerald-50 text-emerald-700',
        OrderStatus::CANCELLED->getValue() => 'border border-rose-200 bg-rose-50 text-rose-700',
        OrderStatus::REFUNDED->getValue() => 'border border-blue-200 bg-blue-50 text-blue-700',
    ];

    $copy = [
        'quantity' => 'الكمية:',
        'amount' => 'قيمة الطلب:',
        'date' => 'تاريخ الطلب:',
        'pendingTitle' => 'طلبك بالطريق',
        'pendingText' => 'نجهز الشحنة الآن وسيتم إعلامك فور انطلاقها.',
        'processingTitle' => $statusLabels[OrderStatus::PROCESSING->getValue()],
        'processingText' => 'لم يتم دفع قيمة الطلب بعد. يرجى إتمام الدفع ليتم إرسال الطلب.',
        'defaultTitle' => 'حالة الطلب الحالية',
        'cta' => 'تكملة الخطوات',
        'details' => 'تفاصيل الطلب',
    ];

    $status = $order->status;
    $stateClass = $statePalette[$status] ?? 'border border-slate-200 bg-slate-50 text-slate-700';
@endphp

<div class="card order-card order-card-modern bg-white border border-slate-200 rounded-2xl shadow-sm">
    <div class="flex flex-col gap-4 md:grid md:grid-cols-[auto,1fr,auto] md:items-start">
        <div class="flex flex-col items-center gap-2 md:items-start">
            <img src="{{ $order->product->image ?? asset('images/iconsProduct.png') }}" alt="{{ $order->product->name }}"
                class="order-image w-24 h-24 md:w-28 md:h-28 rounded-xl object-contain border border-slate-200 bg-white shadow-sm">
            <span class="order-status {{ $statusClasses[$status] ?? 'status-open' }} text-xs md:text-sm">
                <i class="fas {{ $statusIcons[$status] ?? 'fa-circle' }}"></i>
                {{ $statusLabels[$status] ?? $status }}
            </span>
        </div>

        <div class="flex flex-col gap-3">
            <h3 class="order-name text-lg font-bold text-slate-900 md:text-xl">{{ $order->product->name }}</h3>

            <div class="flex flex-wrap gap-3 text-sm text-slate-600">
                <span class="inline-flex items-center gap-1"><i class="fas fa-cubes text-primary"></i>
                    {{ $copy['quantity'] }} {{ $order->quantity }}</span>
                <span class="inline-flex items-center gap-1"><i class="fas fa-wallet text-primary"></i>
                    {{ $copy['amount'] }} {{ number_format($order->amount, 2) }} {{ $order->product->currency->code ?? '' }}</span>
                <span class="inline-flex items-center gap-1"><i class="fas fa-calendar-alt text-primary"></i>
                    {{ $copy['date'] }}
                    {{ optional($order->created_at)->format('Y-m-d') ?? $order->created_at }}</span>
            </div>

            <div
                class="order-state-block w-full max-w-3xl mx-auto md:mx-0 rounded-xl px-3 py-3 flex flex-col gap-2 {{ $stateClass }}">
                <div class="flex flex-wrap items-center gap-2 font-semibold text-sm">
                    <i class="fas {{ $statusIcons[$status] ?? 'fa-circle' }}"></i>
                    <span>{{ $statusLabels[$status] ?? $status }}</span>
                </div>

                @if ($status === OrderStatus::PENDING->getValue())
                    <div class="flex flex-wrap items-center gap-3">
                        <p class="state-text text-sm text-slate-700 m-0">{{ $copy['pendingText'] }}</p>
                        <div class="w-20 md:w-24">
                            <x-pending></x-pending>
                        </div>
                    </div>
                @elseif ($status === OrderStatus::PROCESSING->getValue())
                    <div class="flex flex-wrap items-center gap-3">
                        <p class="state-text text-sm text-slate-700 m-0">{{ $copy['processingText'] }}</p>
                        <a href="{{ route('payment.show', ['order_id' => $order->id]) }}"
                            class="btn btn-primary btn-compact text-sm px-4 py-2">
                            <i class="fas fa-arrow-left"></i>
                            {{ $copy['cta'] }}
                        </a>
                    </div>
                @else
                    <p class="state-text text-sm text-slate-700 m-0">{{ $copy['defaultTitle'] }}</p>
                @endif
            </div>
        </div>

        <div class="order-actions flex flex-col gap-2 items-center justify-start">
            <a href="{{ route('my.order') }}" class="btn btn-secondary">
                <i class="fas fa-eye"></i>
                {{ $copy['details'] }}
            </a>
        </div>
    </div>
</div>
