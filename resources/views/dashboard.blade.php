@php($title = $title ?? __('dashboard.title'))

@extends('layouts.app')

@section('content')
    <div class="dashboard-page">
        <div class="section-head">
            <div>
                <div class="eyebrow">{{ __('dashboard.eyebrow') }}</div>
                <h1 class="section-title">
                    {!! __('dashboard.welcome', ['name' => $user->name]) !!}
                </h1>
                <p class="muted">{{ __('dashboard.muted') }}</p>
            </div>
            <div class="chip">
                <i class="fas fa-shield-check"></i>
                {{ $user->role->label() ?? __('dashboard.role_default') }}
            </div>
        </div>

        <div class="summary-cards" style="margin-bottom: 18px;">
            <div class="summary-card">
                <div class="label"><i class="fas fa-receipt"></i> {{ __('dashboard.summary.total_orders') }}</div>
                <div class="value">{{ number_format($ordersTotal) }}</div>
                <div class="pill"><i class="fas fa-clipboard-check"></i> {{ __('dashboard.summary.closed_label') }}: {{ number_format($ordersClosed) }}</div>
            </div>
            <div class="summary-card">
                <div class="label"><i class="fas fa-box-open"></i> {{ __('dashboard.summary.in_progress') }}</div>
                <div class="value">{{ number_format($ordersInProgress) }}</div>
                <div class="meta-line">{{ __('dashboard.summary.pending') }}: {{ number_format($ordersPending) }} • {{ __('dashboard.summary.processing') }}: {{ number_format($ordersProcessing) }}</div>
            </div>
            <div class="summary-card">
                <div class="label"><i class="fas fa-circle-check"></i> {{ __('dashboard.summary.completed') }}</div>
                <div class="value">{{ number_format($ordersCompleted) }}</div>
                <div class="meta-line">{{ __('dashboard.summary.cancelled_refunded') }}: {{ number_format($ordersCancelled + $ordersRefunded) }}</div>
            </div>
            <div class="summary-card">
                <div class="label"><i class="fas fa-wallet"></i> {{ __('dashboard.summary.total_paid') }}</div>
                <div class="value">{{ number_format($paymentsCompletedTotal, 2) }} {{ optional($user->currency)->code ?? '' }}</div>
                <div class="meta-line">
                    {{ __('dashboard.summary.successful_ops') }}: {{ number_format($paymentsCompletedCount) }}
                    @if ($lastPayment)
                        • {{ __('dashboard.summary.last_payment') }} {{ optional($lastPayment->created_at)->diffForHumans() }}
                    @endif
                </div>
            </div>
        </div>

        <div class="status-grid">
            <div class="stat-card">
                <span class="stat-number">{{ $user->email }}</span>
                <span class="stat-label">{{ __('dashboard.status.email_label') }}</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $emailVerified ? __('dashboard.status.active') : __('dashboard.status.inactive') }}</span>
                <span class="stat-label">{{ __('dashboard.status.email_verified_label') }}</span>
            </div>
            <div class="stat-card">
                <span class="stat-number">{{ $twoFactorEnabled ? __('dashboard.status.active') : __('dashboard.status.inactive') }}</span>
                <span class="stat-label">{{ __('dashboard.status.two_factor_label') }}</span>
            </div>
        </div>
        <br>
        <div class="dashboard-grid">
            <div class="card">
                <div class="section-head" style="margin-bottom: 12px;">
                    <div>
                        <div class="eyebrow">{{ __('dashboard.basic.eyebrow') }}</div>
                        <h2 class="section-title" style="font-size: 22px;">{{ __('dashboard.basic.title') }}</h2>
                    </div>
                </div>

                <form method="POST" action="{{ route('user-profile-information.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="form-label">{{ __('dashboard.form.name_label') }}</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                               autocomplete="name" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">{{ __('dashboard.form.email_label') }}</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                               autocomplete="username" class="form-input">
                        <p class="muted">{{ __('dashboard.form.email_muted') }}</p>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fas fa-save"></i>
                        {{ __('dashboard.form.save_changes') }}
                    </button>
                </form>
            </div>

            <div class="card">
                <div class="section-head" style="margin-bottom: 12px;">
                    <div>
                        <div class="eyebrow">{{ __('dashboard.security.eyebrow') }}</div>
                        <h2 class="section-title" style="font-size: 22px;">{{ __('dashboard.security.change_password') }}</h2>
                    </div>
                </div>

                <form method="POST" action="{{ route('user-password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="current_password" class="form-label">{{ __('dashboard.security.current_password_label') }}</label>
                        <input id="current_password" name="current_password" type="password" required autocomplete="current-password"
                               class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">{{ __('dashboard.security.new_password_label') }}</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password"
                               class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">{{ __('dashboard.security.confirm_password_label') }}</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
                               class="form-input">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fas fa-lock"></i>
                        {{ __('dashboard.security.update_password') }}
                    </button>
                </form>
            </div>
        </div>

        @if ($twoFactorEnabled)
            <div class="hero-actions" style="margin-bottom: 12px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" id="toggle-2fa"
                        data-show-label="{{ __('dashboard.twofactor.show_settings') }}"
                        data-hide-label="{{ __('dashboard.twofactor.hide_settings') }}">
                    <i class="fas fa-eye"></i>
                    <span>{{ __('dashboard.twofactor.show_settings') }}</span>
                </button>
            </div>
        @endif

        <div class="card" id="twofactor-card" @if($twoFactorEnabled) style="display: none;" @endif>
            <div class="section-head" style="margin-bottom: 12px;">
                <div>
                    <div class="eyebrow">{{ __('dashboard.twofactor.eyebrow') }}</div>
                    <h2 class="section-title" style="font-size: 22px;">{{ __('dashboard.twofactor.title') }}</h2>
                    <p class="muted">{{ __('dashboard.twofactor.muted') }}</p>
                </div>
                <span class="chip">{{ $twoFactorEnabled ? __('dashboard.status.active') : __('dashboard.status.inactive') }}</span>
            </div>

            @if (! $user->two_factor_secret)
                <div class="info-banner">
                    {{ __('dashboard.twofactor.enable_info') }}
                </div>
                <form method="POST" action="{{ route('two-factor.enable') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fas fa-shield-halved"></i>
                        {{ __('dashboard.twofactor.enable_button') }}
                    </button>
                </form>
            @elseif (! $twoFactorEnabled)
                <div class="info-banner">
                    {{ __('dashboard.twofactor.scan_qr_info') }}
                </div>

                @if ($user->two_factor_secret)
                    <div class="card" style="padding: 16px; margin-bottom: 16px;">
                        {!! $user->twoFactorQrCodeSvg() !!}
                    </div>
                @endif

                <form method="POST" action="{{ route('two-factor.confirm') }}" class="dashboard-grid" style="grid-template-columns: 1fr;">
                    @csrf
                    <div class="form-group">
                        <label for="code" class="form-label">{{ __('dashboard.twofactor.code_label') }}</label>
                        <input id="code" name="code" type="text" inputmode="numeric" required autocomplete="one-time-code"
                               class="form-input">
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                        <i class="fas fa-check-circle"></i>
                        {{ __('dashboard.twofactor.confirm_button') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('two-factor.disable') }}" style="margin-top: 10px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-ghost" style="width: 100%; justify-content: center;">
                        {{ __('dashboard.twofactor.disable_button') }}
                    </button>
                </form>
            @else
                <div class="status-grid" style="margin-bottom: 14px;">
                    <div class="stat-card">
                        <span class="stat-number">{{ __('dashboard.status.active') }}</span>
                        <span class="stat-label">{{ __('dashboard.twofactor.activated_label', ['time' => optional($user->two_factor_confirmed_at)->diffForHumans()]) }}</span>
                    </div>
                    <div class="stat-card">
                        <span class="stat-number">{{ __('dashboard.twofactor.recovery_codes_label') }}</span>
                        <span class="stat-label">{{ __('dashboard.twofactor.recovery_codes_hint') }}</span>
                    </div>
                </div>

                <div class="dashboard-grid">
                    <div class="card" style="margin-bottom: 0;">
                        <h3 class="section-title" style="font-size: 18px; margin-bottom: 12px;">{{ __('dashboard.twofactor.qr_title') }}</h3>
                        <div class="card" style="padding: 16px; margin: 0;">
                            {!! $user->twoFactorQrCodeSvg() !!}
                        </div>
                    </div>

                    <div class="card" style="margin-bottom: 0;">
                            <div class="section-head" style="margin-bottom: 10px;">
                            <div class="eyebrow">{{ __('dashboard.twofactor.recovery_codes_eyebrow') }}</div>
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
                                    {{ __('dashboard.twofactor.regenerate_codes') }}
                                </button>
                            </form>

                            <form method="POST" action="{{ route('two-factor.disable') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost">
                                    {{ __('dashboard.twofactor.disable_button') }}
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
                    const show = toggle.getAttribute('data-show-label') || '';
                    const hide = toggle.getAttribute('data-hide-label') || '';
                    label.textContent = visible ? hide : show;
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
