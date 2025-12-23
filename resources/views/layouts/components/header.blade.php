@php($showActions = $showActions ?? true)


<header class="header">
    <div class="container header-content">
        <div class="nav-left">
            <a href="{{ url('/') }}" class="logo" aria-label="{{ config('app.name', 'JumlaHub') }}">
                <img class="logo-img" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'JumlaHub') }} logo"
                    loading="lazy">
            </a>
            <nav class="nav-links">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">{{ __('layout.header.home') }}</a>
                    <a href="{{ url('/#categories') }}">{{ __('layout.header.categories') }}</a>
                    <a href="{{ url('/#products') }}">{{ __('layout.header.products') }}</a>
                @auth
                        <a href="{{ url('/orders') }}" class="{{ request()->is('orders*') ? 'active' : '' }}">{{ __('layout.header.orders') }}</a>
                @endauth
            </nav>
        </div>

        <form action="{{ url('/products') }}" method="GET" class="search">
            <input type="search" name="q" value="{{ request('q') }}"
                placeholder="{{ __('layout.header.search_placeholder') }}" aria-label="{{ __('layout.header.search_aria') }}">
            <i class="fas fa-search"></i>
        </form>

        @if ($showActions)
            <div class="nav-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-ghost">
                        <i class="fas fa-chart-line"></i>
                        {{ __('layout.header.dashboard') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-arrow-right-from-bracket"></i>
                            {{ __('layout.header.logout') }}
                        </button>
                    </form>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="btn btn-ghost">
                            <i class="fas fa-right-to-bracket"></i>
                            {{ __('layout.header.login') }}
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-secondary">
                            <i class="fas fa-user-plus"></i>
                            {{ __('layout.header.register') }}
                        </a>
                    @endif
                @endauth
            </div>
        @endif

        <form method="POST" action="{{ route('preferences.update') }}" class="d-flex align-items-center gap-2 me-3">
            @csrf
            <select name="language" class="form-select form-select-sm w-auto">
                @foreach ($languages as $language)
                    <option value="{{ $language->code }}"
                        {{ app()->getLocale() == $language->code ? 'selected' : '' }}>
                        {{ $language->name }}
                    </option>
                @endforeach
            </select>

            <select name="currency" class="form-select form-select-sm w-auto">
                @foreach ($currencies as $currency)
                    <option value="{{ $currency->code }}" {{ app('currency') === $currency->code ? 'selected' : '' }}>
                        {{ $currency->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>
    <x-toast />
</header>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="{{ route('preferences.update') }}"]');
        const selects = form.querySelectorAll('select');

        selects.forEach(select => {
            select.addEventListener('change', function() {
                form.submit();
            });
        });
    });
</script>
