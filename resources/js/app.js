import "./bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    /* ===============================
       Country → City Ajax
    =============================== */
    const countrySelect = document.getElementById("country_id");
    const citySelect = document.getElementById("city_id");

    if (countrySelect && citySelect) {
        countrySelect.addEventListener("change", function () {
            const countryId = this.value;

            const t = window.JH_TRANSLATIONS?.menu || {};
            citySelect.innerHTML = `<option value="">${t.loading || 'Loading...'}</option>`;

            if (!countryId) {
                citySelect.innerHTML = `<option value="">${t.city_placeholder || 'Select city'}</option>`;
                return;
            }

            fetch(`/countries/${countryId}/cities`)
                .then((res) => res.json())
                .then((cities) => {
                    citySelect.innerHTML = `<option value="">${t.city_placeholder || 'Select city'}</option>`;

                    cities.forEach((city) => {
                        const option = document.createElement("option");
                        option.value = city.id;
                        option.textContent = city.name;
                        citySelect.appendChild(option);
                    });
                })
                .catch(() => {
                    citySelect.innerHTML = `<option value="">${t.error || 'An error occurred'}</option>`;
                });
        });
    }

    /* ===============================
       Filters & Search
    =============================== */
    const searchForm = document.querySelector(".search");
    const searchInput = document.querySelector('input[name="q"]');
    const statusSelect = document.querySelector('select[name="status"]');
    const sortSelect = document.querySelector('select[name="sort"]');

    if (!searchForm || !searchInput || !statusSelect || !sortSelect) return;

    function updateQuery() {
        const url = new URL(window.location.href);

        searchInput.value.trim()
            ? url.searchParams.set("q", searchInput.value.trim())
            : url.searchParams.delete("q");

        statusSelect.value
            ? url.searchParams.set("status", statusSelect.value)
            : url.searchParams.delete("status");

        sortSelect.value
            ? url.searchParams.set("sort", sortSelect.value)
            : url.searchParams.delete("sort");

        window.location.href = url.toString();
    }

    statusSelect.addEventListener("change", updateQuery);
    sortSelect.addEventListener("change", updateQuery);

    searchForm.addEventListener("submit", function (e) {
        e.preventDefault();
        updateQuery();
    });
});
