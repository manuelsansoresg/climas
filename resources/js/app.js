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

    // Preview de imágenes
    const imageInput = document.getElementById('image');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('img');
                    preview.src = e.target.result;
                    preview.style.maxWidth = '200px';
                    preview.style.marginTop = '10px';
                    const container = imageInput.parentElement;
                    const existingPreview = container.querySelector('img');
                    if (existingPreview) {
                        container.removeChild(existingPreview);
                    }
                    container.appendChild(preview);
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }

    // Preview de imágenes múltiples
    const imagesInput = document.getElementById('images');
    if (imagesInput) {
        imagesInput.addEventListener('change', function(e) {
            const container = this.parentElement;
            const existingPreviews = container.querySelectorAll('.image-preview');
            existingPreviews.forEach(preview => preview.remove());

            if (e.target.files) {
                Array.from(e.target.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.createElement('img');
                        preview.src = e.target.result;
                        preview.style.maxWidth = '100px';
                        preview.style.margin = '5px';
                        preview.className = 'image-preview';
                        container.appendChild(preview);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });
    }

    // Función para cargar subcategorías
    function loadSubcategories(categoryId) {
        if (!categoryId) return;

        const subcategorySelect = document.getElementById('subcategory_id');
        const subcategory2Select = document.getElementById('subcategory2_id');
        const subcategory3Select = document.getElementById('subcategory3_id');

        subcategorySelect.innerHTML = '<option value="">Seleccione una subcategoría</option>';
        subcategory2Select.innerHTML = '<option value="">Seleccione una subcategoría 2</option>';
        subcategory3Select.innerHTML = '<option value="">Seleccione una subcategoría 3</option>';

        fetch(`/admin/categories/${categoryId}/subcategories`)
            .then(response => response.json())
            .then(data => {
                data.forEach(subcategory => {
                    const option = document.createElement('option');
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    subcategorySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Función para cargar subcategorías2
    function loadSubcategories2(subcategoryId) {
        if (!subcategoryId) return;

        const subcategory2Select = document.getElementById('subcategory2_id');
        const subcategory3Select = document.getElementById('subcategory3_id');

        subcategory2Select.innerHTML = '<option value="">Seleccione una subcategoría 2</option>';
        subcategory3Select.innerHTML = '<option value="">Seleccione una subcategoría 3</option>';

        fetch(`/admin/subcategories/${subcategoryId}/subcategories2`)
            .then(response => response.json())
            .then(data => {
                data.forEach(subcategory2 => {
                    const option = document.createElement('option');
                    option.value = subcategory2.id;
                    option.textContent = subcategory2.name;
                    subcategory2Select.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Función para cargar subcategorías3
    function loadSubcategories3(subcategory2Id) {
        if (!subcategory2Id) return;

        const subcategory3Select = document.getElementById('subcategory3_id');
        subcategory3Select.innerHTML = '<option value="">Seleccione una subcategoría 3</option>';

        fetch(`/admin/subcategories2/${subcategory2Id}/subcategories3`)
            .then(response => response.json())
            .then(data => {
                data.forEach(subcategory3 => {
                    const option = document.createElement('option');
                    option.value = subcategory3.id;
                    option.textContent = subcategory3.name;
                    subcategory3Select.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // Inicializar los selectores de categorías si existen
    const categorySelect = document.getElementById('category_id');
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            loadSubcategories(this.value);
        });

        document.getElementById('subcategory_id').addEventListener('change', function() {
            loadSubcategories2(this.value);
        });

        document.getElementById('subcategory2_id').addEventListener('change', function() {
            loadSubcategories3(this.value);
        });

        // Cargar subcategorías iniciales si hay una categoría seleccionada
        if (categorySelect.value) {
            loadSubcategories(categorySelect.value);
        }
    }

    // --- PRODUCTOS: EDICIÓN DE IMÁGENES ---
    window.previewMainImage = function(input) {
        const previewImg = document.getElementById('previewImage');
        const deleteBtn = document.getElementById('mainImageDeleteBtn');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewImg.style.display = 'block';
                if (deleteBtn) deleteBtn.style.display = 'inline-block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            previewImg.src = '';
            previewImg.style.display = 'none';
            if (deleteBtn) deleteBtn.style.display = 'none';
        }
    }

    document.getElementById('image')?.addEventListener('change', function() {
        window.previewMainImage(this);
    });

    document.getElementById('mainImageDeleteBtn')?.addEventListener('click', function() {
        const previewImg = document.getElementById('previewImage');
        const input = document.getElementById('image');
        previewImg.src = '';
        previewImg.style.display = 'none';
        this.style.display = 'none';
        if (input) input.value = '';
    });

    window.previewAdditionalImages = function(input) {
        const preview = document.getElementById('additionalImagesPreview');
        // Elimina previews previos generados por JS
        Array.from(preview.querySelectorAll('.js-preview')).forEach(el => el.remove());
        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'd-inline-block position-relative me-2 mb-2 js-preview';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Vista previa" style="max-width: 100px;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 btn-remove-preview">×</button>
                    `;
                    preview.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    }

    window.removeAdditionalImage = function(index) {
        const dt = new DataTransfer();
        const input = document.getElementById('images');
        const { files } = input;
        for (let i = 0; i < files.length; i++) {
            if (i !== index) {
                dt.items.add(files[i]);
            }
        }
        input.files = dt.files;
        window.previewAdditionalImages(input);
    }

    window.deleteMainProductImage = function(productId) {
        if (confirm('¿Seguro que deseas eliminar la imagen principal?')) {
            fetch(`/admin/products/${productId}/delete-main-image`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('previewImage').style.display = 'none';
                    document.getElementById('mainImageDeleteBtn').style.display = 'none';
                } else {
                    alert('No se pudo eliminar la imagen');
                }
            });
        }
    }

    window.deleteProductImage = function(imageId) {
        console.log('Intentando borrar imagen adicional con id:', imageId);
        if (!imageId || isNaN(Number(imageId))) {
            alert('ID de imagen adicional inválido.');
            return;
        }
        if (confirm('¿Seguro que deseas eliminar esta imagen adicional?')) {
            fetch(`/admin/products/images/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    var imgDiv = document.getElementById('product-image-' + imageId);
                    if (imgDiv) imgDiv.remove();
                } else {
                    alert('No se pudo eliminar la imagen adicional');
                }
            });
        }
    }

    document.addEventListener('click', function(e) {
        // Borrar imagen adicional de la base de datos
        if (e.target && e.target.classList.contains('btn-delete-adicional')) {
            const imageId = e.target.getAttribute('data-id');
            console.log('Click en botón eliminar adicional, id:', imageId);
            if (imageId && !isNaN(Number(imageId))) {
                if (confirm('¿Seguro que deseas eliminar esta imagen adicional?')) {
                    fetch(`/admin/products/images/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            var imgDiv = document.getElementById('product-image-' + imageId);
                            if (imgDiv) imgDiv.remove();
                        } else {
                            alert('No se pudo eliminar la imagen adicional');
                        }
                    });
                }
            } else {
                alert('ID de imagen adicional inválido.');
            }
        }
        // Borrar preview local de imagen nueva
        if (e.target && e.target.classList.contains('btn-remove-preview')) {
            const previewDiv = e.target.closest('.js-preview');
            if (previewDiv) previewDiv.remove();
        }
    });
});
