@php
    $productId = $product->id;
    $modalId = 'create-order-' . $productId;
    $price = (float) ($product->price ?? 0);
    $available = (int) ($product->quantity ?? 0);
    $sold = (int) ($product->quantity_sold ?? 0);
    $canOrder = $available - $sold >= 0;
@endphp


<div class="order-modal" id="{{ $modalId }}" role="dialog" aria-modal="true"
    aria-labelledby="{{ $modalId }}-title" aria-hidden="true">
    <div class="order-modal-card card">
        <button type="button" class="modal-close" aria-label="إغلاق النافذة" data-modal-close>
            <i class="fas fa-xmark"></i>
        </button>

        <div class="modal-body">
            <div class="modal-preview">
                <div class="chip">{{ $product->category->name ?? 'منتج' }}</div>
                <img src="{{ $product->image ?? asset('images/iconsProduct.png') }}" alt="{{ $product->name }}"
                    class="modal-image">
                <h3 id="{{ $modalId }}-title">{{ $product->name }}</h3>
                @if (!empty($product->description))
                    <p class="muted">{{ \Illuminate\Support\Str::limit($product->description, 120) }}</p>
                @else
                    <p class="muted">جهز طلبك وأضف ملاحظاتك الخاصة، وسيتم مراجعة التفاصيل مع فريق المبيعات فوراً.
                    </p>
                @endif

                <div class="price-row">
                    <span class="price-figure">{{ number_format($price, 2) }}</span>
                    <span class="price-unit">/ {{ $product->unit ?? 'وحدة' }}</span>
                </div>

                <div class="modal-meta">
                    <span><i class="fas fa-boxes-stacked"></i> المتاح الآن: {{ $available }}</span>
                    <span><i class="fas fa-check-double"></i> تم بيع: {{ $sold }}</span>
                    <span><i class="fas fa-clock"></i> جاهز للتجهيز والشحن</span>
                </div>
            </div>

            <div class="modal-form">
                <div class="modal-headline">
                    <div class="eyebrow">
                        <i class="fas fa-clipboard-check"></i>
                        تفاصيل الطلب
                    </div>
                    <h3>أدخل بياناتك لنبدأ تجهيز الشحنة</h3>
                    <p class="muted">سنراجع الطلب ونقوم بتأكيده معك، مع اختيار وسيلة الدفع الأنسب لك.</p>
                </div>

                <form method="POST" action="{{ route('create.order') }}" class="order-form">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    {{-- <input type="hidden" name="amount" data-field="amount"
                        value="{{ number_format($canOrder ? $price : 0, 2, '.', '') }}"> --}}

                    <div class="modal-grid">
                        <div class="form-group">
                            <label class="form-label" for="{{ $modalId }}-quantity">الكمية المطلوبة</label>
                            <input id="{{ $modalId }}-quantity" type="number" name="quantity" class="form-input"
                                min="1"
                                @if ($canOrder) max="{{ $available }}"
                                        value="1"
                                        required
                                    @else
                                        value="0"
                                        disabled @endif
                                data-field="quantity" inputmode="numeric">
                            <div class="help-text">سيتم تحديث إجمالي الطلب تلقائياً.</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="{{ $modalId }}-payment">طريقة الدفع المفضلة</label>
                            <select id="{{ $modalId }}-payment" name="payment_provider_id" class="form-input">
                                <option value="">اختر وسيلة الدفع</option>
                                @foreach ($paymentProviders->cursor() as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <label class="form-label" for="{{ $modalId }}-notes">ملاحظات خاصة</label>
                        <textarea id="{{ $modalId }}-notes" name="notes" class="form-input" rows="3"
                            placeholder="أخبرنا بتفاصيل الاستلام أو الشحن أو أي متطلبات خاصة"></textarea>
                    </div> --}}

                    @unless ($canOrder)
                        <div class="alert" style="margin-top: 0;">
                            <i class="fas fa-circle-exclamation"></i>
                            الكمية غير متوفرة حالياً، سنخبرك بمجرد إعادة التوريد.
                        </div>
                    @endunless

                    <div class="order-total">
                        <div>
                            <span class="muted">إجمالي تقديري</span>
                            <div class="total-number" data-amount-preview>
                                {{ number_format($canOrder ? $price : 0, 2) }}
                            </div>
                        </div>
                        <div class="pill">
                            <i class="fas fa-shield-check"></i>
                            الأسعار تشمل الدعم حتى التسليم
                        </div>
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="btn btn-ghost" data-modal-close>إلغاء</button>
                        <button type="submit" class="btn btn-primary" {{ $canOrder ? '' : 'disabled' }}>
                            <i class="fas fa-paper-plane"></i>
                            تأكيد الطلب
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    (() => {
        const modalId = '{{ $modalId }}';
        const modal = document.getElementById(modalId);
        if (!modal) return;

        const openers = document.querySelectorAll(`[data-modal-open="${modalId}"]`);
        const closers = modal.querySelectorAll('[data-modal-close]');
        const quantityInput = modal.querySelector('[data-field="quantity"]');
        const amountInput = modal.querySelector('[data-field="amount"]');
        const amountPreview = modal.querySelector('[data-amount-preview]');
        const unitPrice = {{ number_format($price, 2, '.', '') }};
        const canOrder = {{ $canOrder ? 'true' : 'false' }};

        const toggleModal = (show) => {
            modal.classList.toggle('is-visible', show);
            modal.setAttribute('aria-hidden', show ? 'false' : 'true');
            document.body.classList.toggle('modal-open', show);

            if (show && quantityInput && canOrder) {
                quantityInput.focus();
            }
        };

        openers.forEach((btn) =>
            btn.addEventListener('click', () => {
                if (quantityInput && canOrder) {
                    quantityInput.value = Math.max(1, Number(quantityInput.value) || 1);
                }
                toggleModal(true);
            }),
        );
        closers.forEach((btn) => btn.addEventListener('click', () => toggleModal(false)));
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                toggleModal(false);
            }
        });
        window.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                toggleModal(false);
            }
        });

        const updateAmount = () => {
            if (!quantityInput || !amountInput || !amountPreview) return;

            if (!canOrder) {
                amountInput.value = '0.00';
                amountPreview.textContent = '0.00';
                return;
            }

            const qtyRaw = Number(quantityInput.value);
            const qty = Number.isFinite(qtyRaw) && qtyRaw > 0 ? qtyRaw : 1;
            const total = qty * unitPrice;
            amountInput.value = total.toFixed(2);
            amountPreview.textContent = total.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            });
        };

        quantityInput?.addEventListener('input', updateAmount);
        updateAmount();
    })();
</script>
