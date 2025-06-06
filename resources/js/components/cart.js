document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad para agregar al carrito
    const btn = document.getElementById('add-to-cart-btn');
    if (btn) {
        const quantityInput = document.getElementById('quantity');
        const stockDisplay = document.getElementById('stock-display');
        let availableStock = parseInt(btn.getAttribute('data-stock') || '0');

        // Actualizar el display de stock si existe
        if (stockDisplay) {
            stockDisplay.textContent = `Stock disponible: ${availableStock}`;
        }

        // Validar cantidad al cambiar el input
        if (quantityInput) {
            quantityInput.addEventListener('input', function() {
                let value = parseInt(this.value);
                if (value > availableStock) {
                    this.value = availableStock;
                    value = availableStock;
                }
                if (value < 1 || isNaN(value)) {
                    this.value = 1;
                }
            });
        }

        btn.addEventListener('click', function() {
            const productId = btn.getAttribute('data-product-id');
            const url = btn.getAttribute('data-url');
            const csrfToken = btn.getAttribute('data-csrf');
            const quantity = parseInt(quantityInput?.value || '1');

            // Validar stock en backend antes de agregar
            fetch(`/api/product/${productId}/stock`)
                .then(res => res.json())
                .then(stockData => {
                    availableStock = parseInt(stockData.stock);
                    btn.setAttribute('data-stock', availableStock);
                    if (stockDisplay) {
                        stockDisplay.textContent = `Stock disponible: ${availableStock}`;
                    }
                    quantityInput.max = availableStock;
                    if (quantity > availableStock) {
                        alert(`Error: Solo hay ${availableStock} unidades disponibles`);
                        quantityInput.value = availableStock > 0 ? availableStock : 1;
                        return;
                    }

                    // Mostrar indicador de carga
                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Agregando...';

                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ product_id: productId, quantity: quantity })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => Promise.reject(err));
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Restaurar el botón
                        btn.disabled = false;
                        btn.innerHTML = 'Agregar al carrito';

                        // Mostrar mensaje de éxito o advertencia
                        const alertDiv = document.createElement('div');
                        if (data.message && data.message.includes('ya fue agregado')) {
                            alertDiv.className = 'alert alert-warning alert-dismissible fade show';
                        } else {
                            alertDiv.className = 'alert alert-success alert-dismissible fade show';
                        }
                        alertDiv.innerHTML = `
                            ${data.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        const container = document.querySelector('.container');
                        const card = document.querySelector('.card');
                        if (container) {
                            if (card && card.parentNode === container) {
                                container.insertBefore(alertDiv, card);
                            } else {
                                container.insertBefore(alertDiv, container.firstChild);
                            }
                        }

                        // Redirigir si es necesario
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        }
                    })
                    .catch(error => {
                        // Restaurar el botón
                        btn.disabled = false;
                        btn.innerHTML = 'Agregar al carrito';

                        // Mostrar mensaje de error
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            ${error.message || 'Error al agregar al carrito'}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        const container = document.querySelector('.container');
                        const card = document.querySelector('.card');
                        if (container) {
                            if (card && card.parentNode === container) {
                                container.insertBefore(alertDiv, card);
                            } else {
                                container.insertBefore(alertDiv, container.firstChild);
                            }
                        }
                    });
                });
        });
    }

    // Funcionalidad para validar cantidad en el carrito
    const quantityForms = document.querySelectorAll('.quantity-form');
    quantityForms.forEach(form => {
        const input = form.querySelector('.quantity-input');
        const updateBtn = form.querySelector('.update-btn');
        const stockBadge = form.querySelector('.stock-badge');
        const stockWarning = form.querySelector('.stock-warning');
        const stockValue = form.querySelector('.stock-value');
        const maxStock = parseInt(input.getAttribute('data-current-stock'));

        function validateQuantity() {
            if (isNaN(maxStock) || maxStock < 1) {
                stockValue.textContent = 'Sin stock';
                stockBadge.classList.remove('bg-secondary', 'bg-danger');
                stockBadge.classList.add('bg-dark', 'text-white');
                input.disabled = true;
                updateBtn.disabled = true;
                stockWarning.classList.add('d-none');
                return;
            }
            stockValue.textContent = maxStock;
            input.disabled = false;
            const value = parseInt(input.value);
            if (value > maxStock) {
                input.value = maxStock;
                stockBadge.classList.remove('bg-secondary');
                stockBadge.classList.add('bg-danger');
                stockBadge.classList.add('text-white');
                stockWarning.classList.remove('d-none');
                updateBtn.disabled = true;
            } else {
                stockBadge.classList.remove('bg-danger');
                stockBadge.classList.add('bg-secondary');
                stockBadge.classList.add('text-white');
                stockWarning.classList.add('d-none');
                updateBtn.disabled = false;
            }
        }

        // Validar al cargar
        validateQuantity();
        // Validar en cada cambio
        input.addEventListener('input', validateQuantity);
    });

    // Funcionalidad para cerrar alertas
    document.querySelectorAll('.alert .close-btn, .alert .btn-close').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.alert').style.display = 'none';
        });
    });
});