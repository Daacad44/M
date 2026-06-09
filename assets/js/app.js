document.addEventListener('DOMContentLoaded', function () {
    // DataTables
    if (typeof $.fn.DataTable !== 'undefined') {
        $('.data-table').DataTable({
            pageLength: 10,
            responsive: true,
            order: [],
            language: { search: '', searchPlaceholder: 'Search...' }
        });
    }

    // Trip type toggle
    const tripRadios = document.querySelectorAll('input[name="trip_type"]');
    const returnField = document.querySelector('.return-date-field');
    tripRadios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            if (returnField) {
                returnField.style.display = this.value === 'round_trip' ? '' : 'none';
            }
        });
    });

    // Coupon validation
    const applyCouponBtn = document.getElementById('applyCoupon');
    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', function () {
            const code = document.getElementById('couponCode').value;
            const totalEl = document.getElementById('totalAmount');
            const msgEl = document.getElementById('couponMessage');
            if (!code) return;

            const amount = parseFloat(totalEl.textContent.replace(/[^0-9.]/g, ''));
            const baseUrl = (document.querySelector('meta[name="base-url"]')?.content || '').replace(/\/$/, '');
            fetch(baseUrl + '/api/validate-coupon', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                body: 'code=' + encodeURIComponent(code) + '&amount=' + amount + '&csrf_token=' + (document.querySelector('[name=csrf_token]')?.value || '')
            })
            .then(r => r.json())
            .then(data => {
                if (data.valid) {
                    msgEl.innerHTML = '<span class="text-success"><i class="fas fa-check"></i> Discount: $' + data.discount.toFixed(2) + '</span>';
                } else {
                    msgEl.innerHTML = '<span class="text-danger"><i class="fas fa-times"></i> ' + data.message + '</span>';
                }
            });
        });
    }

    // Payment form confirmation
    const paymentForm = document.getElementById('paymentForm');
    if (paymentForm) {
        paymentForm.addEventListener('submit', function (e) {
            const btn = document.getElementById('payBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
        });
    }

    // Newsletter AJAX
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.json())
            .then(data => {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: data.success ? 'success' : 'error', title: data.message, timer: 3000 });
                }
                if (data.success) this.reset();
            });
        });
    }
});
