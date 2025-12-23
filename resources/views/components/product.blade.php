<div class="card product-card">
    <img src="{{ $product['image'] ?? asset('images/iconsProduct.png') }}" alt="{{ $product['name'] }}"
        class="product-image">
    <div class="product-body">
        <div class="hero-actions" style="margin: 0 0 8px;">
            {{-- <span class="pill">{{ $product['badge'] }}</span> --}}
            <span class="chip">{{ $product->category->name }}</span>
        </div>
        <h3 class="product-name">{{ $product['name'] }}</h3>
        <div class="product-price">
            {{ $product['price'] }} {{ $product->currency->code ?? '' }}
            <span>{{ $product['unit'] }}</span>
        </div>

        <div class="progress-container">
            <div class="progress-bar">
                <div class="progress-fill"
                    style="width: {{ ($product['quantity_sold'] / $product['quantity']) * 100 }}%;">
                </div>
            </div>
            <div class="progress-text">
                <span>{{ $product['quantity_sold'] }} {{ __('components.product.sold') }}</span>
                <span>{{ $product['quantity'] - $product['quantity_sold'] }} {{ __('components.product.remaining') }}</span>
            </div>
        </div>

        <div class="stock-stats">
            <span><i class="fas fa-warehouse"></i> {{ __('components.product.min_order') }}</span>
            <span><i class="fas fa-truck"></i> {{ __('components.product.delivery_time') }}</span>
        </div>

        <div class="hero-actions" style="margin-top: 12px;">
            <button type="button" class="btn btn-primary" data-modal-open="{{ 'create-order-' . $product->id }}">
                <i class="fas fa-cart-plus"></i>
                {{ __('components.product.create_order') }}
            </button>



            <a href="{{ route('main.product.show', ['id' => $product->id]) }}" class="btn btn-ghost">
                <i class="fas fa-eye"></i>
                {{ __('components.product.details') }}
            </a>

            {{-- <x-share :id="$product->id" class="btn btn-primary" /> --}}

        </div>
    </div>
</div>
