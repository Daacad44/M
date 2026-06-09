document.addEventListener('DOMContentLoaded', function () {
    if (typeof $.fn.DataTable !== 'undefined') {
        $('.data-table').DataTable({
            pageLength: 15,
            responsive: true,
            order: []
        });
    }

    // Highlight active sidebar link
    const currentPath = window.location.pathname;
    document.querySelectorAll('.admin-nav .nav-link').forEach(function (link) {
        if (link.getAttribute('href') && currentPath.includes(link.getAttribute('href').split('/').pop())) {
            link.classList.add('active');
            link.style.color = '#fff';
            link.style.background = 'rgba(255,255,255,0.15)';
        }
    });
});
