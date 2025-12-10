@php($title = $title ?? 'لوحة التحكم')

@extends('layouts.app')

@section('content')
    <div class="dashboard-page">
        <div class="section-head">
            <div>
                <div class="eyebrow">حسابي</div>
                <h1 class="section-title">
                    أهلاً {{ $user->name }}، اضبط بياناتك وأمان حسابك من هنا
                </h1>
                <p class="muted">تابع حالة حسابك، حدث معلومات الاتصال، وفعل التحقق الثنائي لحماية إضافية.</p>
            </div>
            <div class="chip">
                <i class="fas fa-shield-check"></i>
                {{ $user->role->label() ?? 'مستخدم' }}
            </div>
        </div>

        <div class="summary-cards" style="margin-bottom: 18px;">
            <div class="summary-card">
                <div class="label"><i class="fas fa-receipt"></i> إجمالي الطلبات</div>
                <div class="value">{{ number_format($ordersTotal) }}</div>
                <div class="pill"><i class="fas fa-clipboard-check"></i> مغلقة (تمت/ألغيت/استرداد): {{ number_format($ordersClosed) }}</div>
            </div>
            <div class="summary-card">
                <div class="label"><i class="fas fa-box-open"></i> الطلبات الجارية</div>
                <div class="value">{{ number_format($ordersInProgress) }}</div>
                <div class="meta-line">بانتظار الموافقة: {{ number_format($ordersPending) }} • قيد المعالجة: {{ number_format($ordersProcessing) }}</div>
            </div>
            <div class="summary-card">
                <div class="label"><i class="fas fa-circle-check"></i> الطلبات المكتملة</div>
                <div class="value">{{ number_format($ordersCompleted) }}</div>
                <div class="meta-line">ملغاة/مستردة: {{ number_format($ordersCancelled + $ordersRefunded) }}</div>
            </div>
            <div class="summary-card">
                <div class="label"><i class="fas fa-wallet"></i> إجمالي المدفوع</div>
                <div class="value">{{ number_format($paymentsCompletedTotal, 2) }} {{ optional($user->currency)->code ?? '' }}</div>
                <div class="meta-line">
                    عمليات ناجحة: {{ number_format($paymentsCompletedCount) }}
                    @if ($lastPayment)
                        • آخر عملية {{ optional($lastPayment->created_at)->diffForHumans() }}
                    @endif
                </div>
            </div>
        </div>

        <div class="status-grid">
            <div class="stat-card">
                <span class="stat-number">{{ $user->email }}</span>
                <span class="stat-label">البريد الإلكتروني</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $emailVerified ? 'مفعل' : 'غير مفعل' }}</span>
                <span class="stat-label">توثيق البريد</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $twoFactorEnabled ? 'مفعل' : 'غير مفعل' }}</span>
                <span class="stat-label">التحقق الثنائي</span>
            </div>
        </div>
        <br>
        <div class="dashboard-grid">
            <div class="card">
                <div class="section-head" style="margin-bottom: 12px;">
                    <div>
                        <div class="eyebrow">البيانات الأساسية</div>
                        <h2 class="section-title" style="font-size: 22px;">تحديث معلومات الحساب</h2>
                    </div>
                </div>

                <form method="POST" action="{{ route('user-profile-information.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="form-label">الاسم الكامل</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                               autocomplete="name" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                               autocomplete="username" class="form-input">
                        <p class="muted">سيتم إرسال رمز التحقق إلى البريد عند تغييره.</p>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fas fa-save"></i>
                        حفظ التغييرات
                    </button>
                </form>
            </div>

            <div class="card">
                <div class="section-head" style="margin-bottom: 12px;">
                    <div>
                        <div class="eyebrow">الأمان</div>
                        <h2 class="section-title" style="font-size: 22px;">تغيير كلمة المرور</h2>
                    </div>
                </div>

                <form method="POST" action="{{ route('user-password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                        <input id="current_password" name="current_password" type="password" required autocomplete="current-password"
                               class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">كلمة المرور الجديدة</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="form-input">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fas fa-lock"></i>
                        تحديث كلمة المرور
                    </button>
                </form>
            </div>
        </div>

        @if ($twoFactorEnabled)
            <div class="hero-actions" style="margin-bottom: 12px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" id="toggle-2fa">
                    <i class="fas fa-eye"></i>
                    <span>إظهار إعدادات التحقق بخطوتين</span>
                </button>
            </div>
        @endif

        <div class="card" id="twofactor-card" @if($twoFactorEnabled) style="display: none;" @endif>
            <div class="section-head" style="margin-bottom: 12px;">
                <div>
                    <div class="eyebrow">التحقق الثنائي</div>
                    <h2 class="section-title" style="font-size: 22px;">حماية إضافية بحسابك</h2>
                    <p class="muted">قم بتمكين التحقق الثنائي عبر تطبيق المصادقة لإضافة طبقة أمان إضافية.</p>
                </div>
                <span class="chip">{{ $twoFactorEnabled ? 'مفعل' : 'غير مفعل' }}</span>
            </div>

            @if (! $user->two_factor_secret)
                <div class="info-banner">
                    فعّل التحقق الثنائي للحصول على رموز تسجيل دخول إضافية وحماية أعلى.
                </div>
                <form method="POST" action="{{ route('two-factor.enable') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fas fa-shield-halved"></i>
                        تفعيل التحقق الثنائي
                    </button>
                </form>
            @elseif (! $twoFactorEnabled)
                <div class="info-banner">
                    امسح رمز الـ QR أدناه بتطبيق المصادقة ثم أدخل الرمز لتأكيد التفعيل.
                </div>

                @if ($user->two_factor_secret)
                    <div class="card" style="padding: 16px; margin-bottom: 16px;">
                        {!! $user->twoFactorQrCodeSvg() !!}
                    </div>
                @endif

                <form method="POST" action="{{ route('two-factor.confirm') }}" class="dashboard-grid" style="grid-template-columns: 1fr;">
                    @csrf
                    <div class="form-group">
                        <label for="code" class="form-label">رمز التحقق من التطبيق</label>
                        <input id="code" name="code" type="text" inputmode="numeric" required autocomplete="one-time-code"
                               class="form-input">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fas fa-check-circle"></i>
                        تأكيد التفعيل
                    </button>
                </form>

                <form method="POST" action="{{ route('two-factor.disable') }}" style="margin-top: 10px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-ghost" style="width: 100%; justify-content: center;">
                        إلغاء التحقق الثنائي
                    </button>
                </form>
            @else
                <div class="status-grid" style="margin-bottom: 14px;">
                    <div class="stat-card">
                        <span class="stat-number">فعال</span>
                        <span class="stat-label">تم التفعيل {{ optional($user->two_factor_confirmed_at)->diffForHumans() }}</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">رموز الاسترداد</span>
                        <span class="stat-label">احتفظ بها في مكان آمن</span>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <div class="card" style="margin-bottom: 0;">
                        <h3 class="section-title" style="font-size: 18px; margin-bottom: 12px;">رمز QR</h3>
                        <div class="card" style="padding: 16px; margin: 0;">
                            {!! $user->twoFactorQrCodeSvg() !!}
                        </div>
                    </div>

                    <div class="card" style="margin-bottom: 0;">
                        <div class="section-head" style="margin-bottom: 10px;">
                            <div class="eyebrow">رموز الاسترداد</div>
                        </div>
                        @if ($user->two_factor_recovery_codes)
                            <div class="list">
                                @foreach ($user->recoveryCodes() as $code)
                                    <div class="list-item" style="justify-content: center; font-family: monospace;">
                                        {{ $code }}
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="hero-actions" style="margin-top: 12px;">
                            <form method="POST" action="{{ route('two-factor.regenerate-recovery-codes') }}">
                                @csrf
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-rotate"></i>
                                    تجديد الرموز
                                </button>
                            </form>

                            <form method="POST" action="{{ route('two-factor.disable') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost">
                                    إلغاء التحقق الثنائي
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const card = document.getElementById('twofactor-card');
            const toggle = document.getElementById('toggle-2fa');
            if (!card || !toggle) return;

            const icon = toggle.querySelector('i');
            const label = toggle.querySelector('span');
            const syncLabel = (visible) => {
                if (label) {
                    label.textContent = visible ? 'إخفاء إعدادات التحقق بخطوتين' : 'إظهار إعدادات التحقق بخطوتين';
                }
                if (icon) {
                    icon.classList.toggle('fa-eye', !visible);
                    icon.classList.toggle('fa-eye-slash', visible);
                }
            };

            const isVisible = getComputedStyle(card).display !== 'none';
            syncLabel(isVisible);

            toggle.addEventListener('click', () => {
                const hidden = getComputedStyle(card).display === 'none';
                card.style.display = hidden ? '' : 'none';
                syncLabel(!hidden);
            });
        });
    </script>
@endsection
