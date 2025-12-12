<div class="card order-card">
    <img src="{{ $order->product->image ?? asset('images/iconsProduct.png') }}" alt="{{ $order->product->name }}"
        class="order-image">
    <div class="order-details">
        <h3 class="order-name">{{ $order->product->name }}</h3>
        <div class="order-meta"><i class="fas fa-cubes"></i> الكمية: {{ $order->quantity }} سعر الوحد :
            {{ $order->amount }}</div>
        <div class="order-meta"><i class="fas fa-calendar-alt"></i> تاريخ الطلب: {{ $order->created_at }}</div>
        <span class="order-status status-open"><i class="fas fa-circle"></i> {{ $order->status }}</span>
    </div>
    <div class="raw">
        @if ($order->status == App\Core\Enums\OrderStatus::PROCESSING->getvalue())
            <a href="#" class="col btn btn-secondary">
                <i class="fas fa-eye"></i>
                تكملة الخطوات
            </a>
        @endif
        <a href="product.html" class="col btn btn-secondary">
            <i class="fas fa-eye"></i>
            تفاصيل المنتج
        </a>
    </div>
</div>
