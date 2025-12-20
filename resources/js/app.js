import "./bootstrap";

document.getElementById("country_id").addEventListener("change", function () {
    const countryId = this.value;
    const citySelect = document.getElementById("city_id");

    citySelect.innerHTML = '<option value="">جاري التحميل...</option>';

    if (!countryId) {
        citySelect.innerHTML = '<option value="">اختر المدينة</option>';
        return;
    }

    fetch(`/countries/${countryId}/cities`)
        .then((response) => response.json())
        .then((cities) => {
            citySelect.innerHTML = '<option value="">اختر المدينة</option>';

            cities.forEach((city) => {
                const option = document.createElement("option");
                option.value = city.id;
                option.textContent = city.name;
                citySelect.appendChild(option);
            });
        })
        .catch(() => {
            citySelect.innerHTML = '<option value="">حدث خطأ</option>';
        });

    citySelect.submit();
});

document.addEventListener("DOMContentLoaded", function () {
    const oldCountry = "{{ old('country_id') }}";
    const oldCity = "{{ old('city_id') }}";

    if (oldCountry) {
        fetch(`/countries/${oldCountry}/cities`)
            .then((res) => res.json())
            .then((cities) => {
                const citySelect = document.getElementById("city_id");
                citySelect.innerHTML = '<option value="">اختر المدينة</option>';

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
