import axios from 'axios';

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

        // Nueva función para agregar al carrito con axios y emitir Livewire solo si es exitoso
        window.addToCart = function(button) {
            const productId = button.getAttribute('data-product-id');
            const url = button.getAttribute('data-url');
            const quantity = quantityInput ? parseInt(quantityInput.value) : 1;

            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Agregando...';

            // Validar stock en backend antes de agregar
            axios.get(`/api/product/${productId}/stock`)
                .then(res => {
                    availableStock = parseInt(res.data.stock);
                    button.setAttribute('data-stock', availableStock);
                    if (stockDisplay) {
                        stockDisplay.textContent = `Stock disponible: ${availableStock}`;
                    }
                    if (quantity > availableStock) {
                        alert(`Error: Solo hay ${availableStock} unidades disponibles`);
                        if (quantityInput) quantityInput.value = availableStock > 0 ? availableStock : 1;
                        button.disabled = false;
                        button.innerHTML = 'Agregar al carrito';
                        return Promise.reject();
                    }
                    // Si hay stock, agregar al carrito
                    return axios.post(url, {
                        product_id: productId,
                        quantity: quantity
                    });
                })
                .then(response => {
                    button.disabled = false;
                    button.innerHTML = 'Agregar al carrito';
                    // Mostrar mensaje de éxito
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        ${response.data.message || 'Producto agregado al carrito'}
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
                    // Emitir evento Livewire solo si fue exitoso
                    if (window.Livewire) {
                        window.Livewire.emit('cartUpdated');
                    }
                })
                .catch(error => {
                    button.disabled = false;
                    button.innerHTML = 'Agregar al carrito';
                    if (error && error.response && error.response.data && error.response.data.message) {
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            ${error.response.data.message}
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
                    }
                });
        };
    }

    // Funcionalidad para validar cantidad en el carrito
    const quantityForms = document.querySelectorAll('.quantity-form');
    quantityForms.forEach(form => {
        const input = form.querySelector('.quantity-input');
        const updateBtn = form.querySelector('.update-btn');
        const stockBadge = form.querySelector('.stock-badge');
        const stockWarning = form.querySelector('.stock-warning');
        const stockValue = form.querySelector('.stock-value');
        let maxStock = parseInt(input.getAttribute('data-current-stock'));
        const productId = input.getAttribute('data-product-id');

        function updateStockUI(stock) {
            maxStock = parseInt(stock);
            input.setAttribute('data-current-stock', maxStock);
            input.max = maxStock;
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
        updateStockUI(maxStock);
        // Validar y consultar stock en cada cambio
        input.addEventListener('input', function() {
            fetch(`/api/product/${productId}/stock`)
                .then(res => res.json())
                .then(data => {
                    updateStockUI(data.stock);
                });
        });
    });

    // Validar stock de todo el carrito antes de checkout
    const checkoutForm = document.getElementById('cart-checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const checkoutBtn = document.getElementById('checkout-btn');
            checkoutBtn.disabled = true;
            checkoutBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Validando...';

            axios.post('/api/cart/validate-stock')
                .then(response => {
                    // Si todo ok, enviar el formulario
                    checkoutForm.submit();
                })
                .catch(error => {
                    // Restaurar el botón
                    checkoutBtn.disabled = false;
                    checkoutBtn.innerHTML = 'Realizar compra';

                    // Mostrar errores y actualizar stocks
                    if (error.response && error.response.data && error.response.data.errors) {
                        error.response.data.errors.forEach(err => {
                            const form = document.querySelector(`form[action*="/cart/item/${err.item_id}/update"]`);
                            if (form) {
                                const stockValue = form.querySelector('.stock-value');
                                const stockBadge = form.querySelector('.stock-badge');
                                stockValue.textContent = err.available > 0 ? err.available : 'Sin stock';
                                if (err.available < 1) {
                                    stockBadge.classList.remove('bg-secondary', 'bg-danger');
                                    stockBadge.classList.add('bg-dark', 'text-white');
                                } else {
                                    stockBadge.classList.remove('bg-secondary');
                                    stockBadge.classList.add('bg-danger', 'text-white');
                                }
                                const input = form.querySelector('.quantity-input');
                                input.value = err.available > 0 ? err.available : 1;
                                input.max = err.available;
                                input.disabled = err.available < 1;
                                const updateBtn = form.querySelector('.update-btn');
                                updateBtn.disabled = true;
                                const stockWarning = form.querySelector('.stock-warning');
                                stockWarning.classList.remove('d-none');
                                stockWarning.textContent = `La cantidad solicitada excede el stock disponible (${err.available})`;
                            }
                        });
                        // Mostrar alerta general
                        const container = document.querySelector('.container');
                        const card = document.querySelector('.card');
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            Algunos productos no tienen suficiente stock. Por favor revisa las cantidades.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        if (container) {
                            if (card && card.parentNode === container) {
                                container.insertBefore(alertDiv, card);
                            } else {
                                container.insertBefore(alertDiv, container.firstChild);
                            }
                        }
                    }
                });
        });
    }

    // Funcionalidad para cerrar alertas
    document.querySelectorAll('.alert .close-btn, .alert .btn-close').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.alert').style.display = 'none';
        });
    });
});