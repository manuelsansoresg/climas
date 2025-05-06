require('./bootstrap');

document.addEventListener('DOMContentLoaded', function () {
    

    // Galería vertical basada en HTML
    function renderGalleryThumbsHTML() {
        const thumbs = Array.from(document.querySelectorAll('#gallery-thumbs .gallery-thumb'));
        const mainImg = document.getElementById('main-img');
        if (!thumbs.length) return;
        if (typeof window.galleryIndexHTML !== 'number') window.galleryIndexHTML = 0;
        // Limita el índice para evitar errores
        if (window.galleryIndexHTML > thumbs.length - 1) window.galleryIndexHTML = Math.max(thumbs.length - 4, 0);
        if (window.galleryIndexHTML < 0) window.galleryIndexHTML = 0;
        // Oculta todas
        thumbs.forEach(img => img.style.display = 'none');
        // Muestra solo 4
        for (let i = window.galleryIndexHTML; i < Math.min(window.galleryIndexHTML + 4, thumbs.length); i++) {
            thumbs[i].style.display = '';
        }
        // Marca la activa
        thumbs.forEach(img => img.classList.remove('active'));
        let active = thumbs.find(img => mainImg && img.src === mainImg.src);
        if (!active) active = thumbs[window.galleryIndexHTML];
        if (active) active.classList.add('active');
    }

    if (document.getElementById('gallery-thumbs')) {
        window.galleryIndexHTML = 0;
        renderGalleryThumbsHTML();
        document.getElementById('gallery-up').onclick = function() {
            if (window.galleryIndexHTML > 0) {
                window.galleryIndexHTML--;
                renderGalleryThumbsHTML();
            }
        };
        document.getElementById('gallery-down').onclick = function() {
            const thumbs = document.querySelectorAll('#gallery-thumbs .gallery-thumb');
            if (window.galleryIndexHTML + 4 < thumbs.length) {
                window.galleryIndexHTML++;
                renderGalleryThumbsHTML();
            }
        };
        // Click en miniatura
        document.querySelectorAll('#gallery-thumbs .gallery-thumb').forEach(function(img, idx) {
            img.onclick = function() {
                document.getElementById('main-img').src = img.src;
                renderGalleryThumbsHTML();
            };
        });
    }
});
