<footer class="footer">
    <div class="container">
        <div>© {{ now()->year }} JumlaHub. جميع الحقوق محفوظة.</div>
        <div class="links">
            <a href="{{ url('/') }}">الرئيسية</a>
            <a href="{{ url('/#categories') }}">الفئات</a>
            <a href="{{ url('/#products') }}">المنتجات</a>
            <a href="{{ url('/orders') }}">الطلبات</a>
            @if (Route::has('login'))
                <a href="{{ route('login') }}">تسجيل الدخول</a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}">حساب جديد</a>
            @endif
        </div>
    </div>
</footer>
