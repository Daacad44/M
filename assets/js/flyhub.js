document.addEventListener('DOMContentLoaded', function () {
    // Trip type toggle - show/hide return field
    const tripRadios = document.querySelectorAll('.flyhub-search-form input[name="trip_type"]');
    const returnField = document.querySelector('.flyhub-return-field');

    function updateReturnField() {
        if (!returnField) return;
        const selected = document.querySelector('.flyhub-search-form input[name="trip_type"]:checked');
        if (selected && selected.value === 'one_way') {
            returnField.classList.add('hidden');
        } else {
            returnField.classList.remove('hidden');
        }
    }

    tripRadios.forEach(function (radio) {
        radio.addEventListener('change', updateReturnField);
    });
    updateReturnField();

    // Swap FROM and TO airports
    const swapBtn = document.getElementById('flyhubSwapBtn');
    if (swapBtn) {
        swapBtn.addEventListener('click', function () {
            const fromSelect = document.querySelector('.flyhub-search-form select[name="from"]');
            const toSelect = document.querySelector('.flyhub-search-form select[name="to"]');
            if (fromSelect && toSelect) {
                const temp = fromSelect.value;
                fromSelect.value = toSelect.value;
                toSelect.value = temp;
            }
        });
    }

    // Search tabs (visual only - Flights is functional)
    const tabs = document.querySelectorAll('.flyhub-tab');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            if (this.dataset.tab !== 'flights') return;
            tabs.forEach(function (t) { t.classList.remove('active'); });
            this.classList.add('active');
        });
    });

    // Legacy trip type toggle for other pages
    const legacyReturnField = document.querySelector('.return-date-field');
    const legacyTripRadios = document.querySelectorAll('#flightSearchForm input[name="trip_type"]');
    legacyTripRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (legacyReturnField) {
                legacyReturnField.style.display = this.value === 'round_trip' ? '' : 'none';
            }
        });
    });
});
