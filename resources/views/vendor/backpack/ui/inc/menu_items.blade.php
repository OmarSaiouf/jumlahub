@php
    $currentLocale = app()->getLocale();
    $currentCounty = app('country');
    $currentCity = app('city');
    $locales = \App\Modules\Admin\Models\Language::pluck('name', 'code')->toArray();
    $countries = \App\Modules\Admin\Models\Country::select('id', 'name')->with('cities');

@endphp

{{-- ===================== --}}
{{-- Preferences --}}
{{-- ===================== --}}
<li class="menu-header small text-uppercase text-muted px-3 mt-2">
    {{ __('menu.preferences') }}
</li>

<form method="POST" action="{{ route('preferences.update') }}" class="px-3">
    @csrf

    {{-- Language --}}
    <div class="mb-1">
        <select class="form-select form-select-sm bg-transparent border-secondary text-success fw-semibold"
            name="language" onchange="this.form.submit()">
            @foreach ($locales as $code => $name)
                <option value="{{ $code }}" @selected($currentLocale === $code)>
                    🌐 {{ $name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Country --}}
    <div class="mb-1">
        <select class="form-select form-select-sm bg-transparent border-secondary text-primary" id="country_id"
            name="country">
            <option value="">{{ __('menu.country') }}</option>
            @foreach ($countries->get() as $country)
                <option value="{{ $country->id }}" @selected($currentCounty && $currentCounty == $country->id)>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- City --}}

    <div>
        <select class="form-select form-select-sm bg-transparent border-secondary text-info" id="city_id"
            name="city" onchange="this.form.submit()">
            <option value="">{{ __('menu.city') }}</option>
            @foreach ($countries->find($currentCounty)->cities as $city)
                @if ($currentCity && $currentCity == $city->id)
                    <option value="{{ $city->id }}" selected>
                        {{ $city->name }}
                    </option>
                @endif
            @endforeach
        </select>
    </div>
</form>

{{-- ===================== --}}
{{-- Main --}}
{{-- ===================== --}}
<li class="menu-header small text-uppercase text-muted px-3 mt-3">
    {{ __('menu.main') }}
</li>

<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i>
        <span>{{ __('menu.dashboard') }}</span>
    </a>
</li>

{{-- ===================== --}}
{{-- System --}}
{{-- ===================== --}}
<li class="menu-header small text-uppercase text-muted px-3 mt-3">
    {{ __('menu.system') }}
</li>

<x-backpack::menu-item :title="__('menu.users')" icon="la la-users" :link="backpack_url('user')" />
<x-backpack::menu-item :title="__('menu.countries')" icon="la la-flag" :link="backpack_url('country')" />
<x-backpack::menu-item :title="__('menu.cities')" icon="la la-city" :link="backpack_url('city')" />
<x-backpack::menu-item :title="__('menu.languages')" icon="la la-language" :link="backpack_url('language')" />
<x-backpack::menu-item :title="__('menu.currencies')" icon="la la-money-bill" :link="backpack_url('currency')" />

{{-- ===================== --}}
{{-- Catalog --}}
{{-- ===================== --}}
<li class="menu-header small text-uppercase text-muted px-3 mt-3">
    {{ __('menu.catalog') }}
</li>

<x-backpack::menu-item :title="__('menu.categories')" icon="la la-tags" :link="backpack_url('category')" />
<x-backpack::menu-item :title="__('menu.products')" icon="la la-box" :link="backpack_url('product')" />

{{-- ===================== --}}
{{-- Sales --}}
{{-- ===================== --}}
<li class="menu-header small text-uppercase text-muted px-3 mt-3">
    {{ __('menu.sales') }}
</li>

<x-backpack::menu-item :title="__('menu.orders')" icon="la la-shopping-cart" :link="backpack_url('order')" />
<x-backpack::menu-item :title="__('menu.payments')" icon="la la-credit-card" :link="backpack_url('payment')" />

{{-- ===================== --}}
{{-- Financial --}}
{{-- ===================== --}}
<li class="menu-header small text-uppercase text-muted px-3 mt-3">
    {{ __('menu.financial') }}
</li>

<x-backpack::menu-item :title="__('menu.invoices')" icon="la la-file-invoice" :link="backpack_url('invoice')" />
<x-backpack::menu-item :title="__('menu.payment_providers')" icon="la la-university" :link="backpack_url('payment-provider')" />





<script>
    document.getElementById("country_id").addEventListener("change", function() {
        const countryId = this.value;
        const citySelect = document.getElementById("city_id");

        citySelect.innerHTML = '<option value="">' + "{{ __('menu.loading') }}" + '</option>';

        if (!countryId) {
            citySelect.innerHTML = '<option value="">' + "{{ __('menu.city') }}" + '</option>';
            return;
        }

        fetch(`/countries/${countryId}/cities`)
            .then((response) => response.json())
            .then((cities) => {
                citySelect.innerHTML = '<option value="">' + "{{ __('menu.city') }}" + '</option>';

                cities.forEach((city) => {
                    const option = document.createElement("option");
                    option.value = city.id;
                    option.textContent = city.name;
                    citySelect.appendChild(option);
                });
            })
            .catch(() => {
                citySelect.innerHTML = '<option value="">' + "{{ __('menu.error') }}" + '</option>';
            });

        citySelect.submit();
    });

    document.addEventListener("DOMContentLoaded", function() {
        const oldCountry = "{{ old('country_id') }}";
        const oldCity = "{{ old('city_id') }}";

        if (oldCountry) {
            fetch(`/countries/${oldCountry}/cities`)
                .then((res) => res.json())
                .then((cities) => {
                    const citySelect = document.getElementById("city_id");
                        citySelect.innerHTML = '<option value="">' + "{{ __('menu.city') }}" + '</option>';

                    cities.forEach((city) => {
                        const option = document.createElement("option");
                        option.value = city.id;
                        option.textContent = city.name;
                        if (city.id == oldCity) {
                            option.selected = true;
                        }
                        citySelect.appendChild(option);
                    });
                });
        }
    });
</script>
