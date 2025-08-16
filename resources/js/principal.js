require('./components/cart');

(() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()

// Funcionalidad de galería de imágenes
document.addEventListener('DOMContentLoaded', function () {
    
    // Galería vertical basada en HTML
    function renderGalleryThumbsHTML() {
        const thumbs = Array.from(document.querySelectorAll('#gallery-thumbs .gallery-thumb'));
        const mainImg = document.getElementById('main-img');
        if (!thumbs.length) return;
        
        if (typeof window.galleryIndexHTML !== 'number') window.galleryIndexHTML = 0;
        
        // Limita el índice para evitar errores
        const maxStartIndex = Math.max(0, thumbs.length - 4);
        if (window.galleryIndexHTML > maxStartIndex) window.galleryIndexHTML = maxStartIndex;
        if (window.galleryIndexHTML < 0) window.galleryIndexHTML = 0;
        
        // Oculta todas las miniaturas
        thumbs.forEach((img, index) => {
            if (index >= window.galleryIndexHTML && index < window.galleryIndexHTML + 4) {
                img.style.display = 'block';
            } else {
                img.style.display = 'none';
            }
        });
        
        // Marca la miniatura activa
        thumbs.forEach(img => img.classList.remove('active'));
        const activeThumb = thumbs.find(img => mainImg && img.src === mainImg.src);
        if (activeThumb) {
            activeThumb.classList.add('active');
        }
    }

    // Función para crear y mostrar modal de imagen
    function showImageModal(imageSrc) {
        // Crear modal si no existe
        let modal = document.getElementById('imageModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'imageModal';
            modal.className = 'modal fade';
            modal.innerHTML = `
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="modalImage" src="" class="img-fluid" alt="Imagen ampliada">
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
        
        // Actualizar imagen del modal
        document.getElementById('modalImage').src = imageSrc;
        
        // Mostrar modal usando Bootstrap
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
    }

    if (document.getElementById('gallery-thumbs')) {
        window.galleryIndexHTML = 0;
        renderGalleryThumbsHTML();
        
        // Botón subir
        const upBtn = document.getElementById('gallery-up');
        if (upBtn) {
            upBtn.onclick = function() {
                if (window.galleryIndexHTML > 0) {
                    window.galleryIndexHTML--;
                    renderGalleryThumbsHTML();
                }
            };
        }
        
        // Botón bajar
        const downBtn = document.getElementById('gallery-down');
        if (downBtn) {
            downBtn.onclick = function() {
                const thumbs = document.querySelectorAll('#gallery-thumbs .gallery-thumb');
                if (window.galleryIndexHTML + 4 < thumbs.length) {
                    window.galleryIndexHTML++;
                    renderGalleryThumbsHTML();
                }
            };
        }
        
        // Delegación de eventos para click en miniaturas
        document.getElementById('gallery-thumbs').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('gallery-thumb')) {
                const mainImg = document.getElementById('main-img');
                if (mainImg) {
                    mainImg.src = e.target.src;
                    renderGalleryThumbsHTML();
                }
            }
        });
        
        // Click en imagen principal para mostrar modal
        const mainImg = document.getElementById('main-img');
        if (mainImg) {
            mainImg.style.cursor = 'pointer';
            mainImg.onclick = function() {
                showImageModal(this.src);
            };
        }
    }
});