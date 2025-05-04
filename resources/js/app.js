require('./bootstrap');

document.addEventListener('DOMContentLoaded', function () {
    const searchToggle = document.getElementById('searchToggle');
    const searchOverlay = document.getElementById('searchOverlay');
    const closeSearch = document.getElementById('closeSearch');
    if (searchToggle && searchOverlay && closeSearch) {
        searchToggle.addEventListener('click', function () {
            searchOverlay.classList.remove('d-none');
        });
        closeSearch.addEventListener('click', function () {
            searchOverlay.classList.add('d-none');
        });
        // Cerrar con ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                searchOverlay.classList.add('d-none');
            }
        });
    }
});
