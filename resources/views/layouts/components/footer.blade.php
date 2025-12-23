<footer class="footer">
    <div class="container">
        <div>{{ __('layout.footer.copyright', ['year' => now()->year, 'app' => config('app.name', 'JumlaHub')]) }}</div>
        <div class="links">
            <a href="{{ url('/') }}">{{ __('layout.header.home') }}</a>
            <a href="{{ url('/#categories') }}">{{ __('layout.header.categories') }}</a>
            <a href="{{ url('/#products') }}">{{ __('layout.header.products') }}</a>
            <a href="{{ url('/orders') }}">{{ __('layout.header.orders') }}</a>
            @if (Route::has('login'))
                <a href="{{ route('login') }}">{{ __('layout.header.login') }}</a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}">{{ __('layout.header.register') }}</a>
            @endif
        </div>
    </div>
</footer>
