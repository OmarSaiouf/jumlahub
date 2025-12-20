@php($title = 'إنشاء حساب تاجر')
@php($subtitle = 'أدخل بيانات متجرك، لغة التواصل، وعملة التسعير لبدء الشراء بالجملة.')
@php($cta = 'بعد التسجيل يمكنك متابعة الطلبات، إدارة فريقك، والحصول على عروض موردين موثقين في JumlaHub.')

@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('register') }}" class="auth-form" enctype="multipart/form-data">
        @csrf

        <div class="grid gap-3 md:grid-cols-2">
            <div class="form-group">
                <label for="name" class="form-label">الاسم الكامل</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                    autocomplete="name" class="form-input" placeholder="الاسم الأول والاسم الأخير">
            </div>

            <div class="form-group">
                <label for="email" class="form-label">البريد الإلكتروني</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    autocomplete="username" class="form-input" placeholder="name@email.com">
            </div>

            <div class="form-group">
                <label for="phone" class="form-label">رقم الجوال</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone') }}" required autocomplete="tel"
                    class="form-input" placeholder="+9665xxxxxxx">
            </div>

            <div class="form-group">
                <label for="language_id" class="form-label">لغة التواصل</label>
                <select id="language_id" name="language_id" required class="form-input">
                    <option value="">اختر اللغة</option>
                    @foreach ($languages as $language)
                        <option value="{{ $language->id }}" @selected(old('language_id') == $language->id)>{{ $language->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="currency_id" class="form-label">العملة الرئيسية</label>
                <select id="currency_id" name="currency_id" required class="form-input">
                    <option value="">اختر العملة</option>
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->id }}" @selected(old('currency_id') == $currency->id)>{{ $currency->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="country_id" class="form-label">الدولة</label>
                <select id="country_id" name="country_id" required class="form-input">
                    <option value="">اختر الدولة</option>
                    @foreach ($countries as $country)
                        <option value="{{ $country->id }}" @selected(old('country_id') == $country->id)>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="city_id" class="form-label">المدينة</label>
                <select id="city_id" name="city_id" required class="form-input">
                    <option value="">اختر المدينة</option>
                </select>
            </div>

        </div>

        <div class="form-group">
            <label for="address" class="form-label">العنوان التفصيلي</label>
            <input id="address" name="address" type="text" value="{{ old('address') }}" class="form-input"
                placeholder="الحي، الشارع، أقرب معلم">
        </div>

        <div class="grid gap-3 md:grid-cols-2">
            <div class="form-group">
                <label for="password" class="form-label">كلمة المرور</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                    class="form-input" placeholder="••••••••">
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    autocomplete="new-password" class="form-input" placeholder="أعد كتابة كلمة المرور">
            </div>
        </div>

        <button type="submit" class="btn btn-primary auth-submit">
            <span>إنشاء الحساب</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12h14M12 5l7 7-7 7" />
            </svg>
        </button>

        <p class="auth-footer">
            لديك حساب بالفعل؟ <a href="{{ route('login') }}">تسجيل الدخول</a>
        </p>
    </form>
@endsection
