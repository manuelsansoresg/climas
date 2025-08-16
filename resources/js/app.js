require('./bootstrap');
require('./components/warehouse');

document.addEventListener('DOMContentLoaded', function () {
    



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
                    //alert('No se pudo eliminar la imagen');
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

    // Variables globales para el rol del cliente y productos
    let clienteSeleccionado = { role: 'Cliente publico en general' };
    let lastProductResults = {};
    let productsAdded = [];

    // Función para obtener el precio según el rol del cliente
    function obtenerPrecioPorRol(producto, role) {
        if (role === 'Cliente mayorista') {
            return producto.precio_mayorista;
        } else if (role === 'Cliente instalador') {
            return producto.precio_instalador;
        } else {
            return producto.precio_publico;
        }
    }

    // Función reutilizable para pedir cantidad
    function pedirCantidad(stock) {
        let cantidad = prompt('Cantidad:', '1');
        if (!cantidad || isNaN(cantidad) || cantidad < 1) {
            alert('Cantidad inválida');
            return null;
        }
        cantidad = parseInt(cantidad);
        if (cantidad > stock) {
            alert('La cantidad no puede ser mayor al stock disponible (' + stock + ')');
            return null;
        }
        return cantidad;
    }

    // --- MÓDULO DE VENTAS: CREAR ---
    if (!window.saleData && document.getElementById('saleForm')) {
        let clienteSeleccionadoCrear = { role: 'Cliente publico en general' };
        let lastProductResultsCrear = {};
        let productsAddedCrear = [];

        function obtenerPrecioPorRolCrear(producto, role) {
            if (role === 'Cliente mayorista') {
                return producto.precio_mayorista;
            } else if (role === 'Cliente instalador') {
                return producto.precio_instalador;
            } else {
                return producto.precio_publico;
            }
        }

        if (document.getElementById('client-search')) {
            $('#client-search').select2({
                placeholder: 'Buscar cliente por nombre, email o RFC',
                ajax: {
                    url: '/api/clients/search',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function (client) {
                                return {
                                    id: client.id,
                                    text: (client.name || '') + ' ' + (client.last_name || ''),
                                    role: client.role || 'Cliente publico en general'
                                };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
                width: '100%',
                templateResult: function (data) {
                    return data.text;
                },
                escapeMarkup: function (markup) { return markup; }
            });

            $('#client-search').on('select2:select', function (e) {
                const data = e.params.data;
                clienteSeleccionadoCrear = data;
            });
        }

        $('#product-search').select2({
            placeholder: 'Buscar producto por nombre',
            ajax: {
                url: '/api/products/search',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    lastProductResultsCrear = {};
                    data.forEach(function(product) {
                        lastProductResultsCrear[product.id] = product;
                    });
                    return {
                        results: data.map(function (product) {
                            return {
                                id: product.id,
                                name: product.name,
                                text: product.name,
                                stock: product.stock,
                                precio_publico: product.precio_publico,
                                precio_mayorista: product.precio_mayorista,
                                precio_instalador: product.precio_instalador,
                                real_cost: product.real_cost
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1,
            width: '100%',
            templateResult: function (data) {
                if (!data.id) return data.text;
                var $container = $('<span></span>');
                $container.text(data.text + ' ');
                if (typeof data.stock !== 'undefined' && typeof data.precio_publico !== 'undefined') {
                    $container.append(
                        $('<span style="float:right;font-size:12px;color:#888;"></span>')
                            .text('Stock: ' + data.stock + ' | $' + parseFloat(data.precio_publico).toFixed(2))
                    );
                }
                return $container;
            },
            escapeMarkup: function (markup) { return markup; }
        });

        document.getElementById('add-product').addEventListener('click', function () {
            const select2Data = $('#product-search').select2('data')[0];
            const product = lastProductResultsCrear[select2Data?.id];
            if (!select2Data) {
                alert('Seleccione un producto');
                return;
            }
            if (!product || typeof product.stock === 'undefined' || typeof product.precio_publico === 'undefined') {
                alert('No se pudo obtener el stock o precio del producto.');
                return;
            }
            if (productsAddedCrear.find(p => p.id == product.id)) {
                alert('Este producto ya fue agregado');
                return;
            }
            let cantidad = pedirCantidad(product.stock);
            if (!cantidad) return;
            const precioUnitario = obtenerPrecioPorRolCrear(product, clienteSeleccionadoCrear.role);
            productsAddedCrear.push({
                id: product.id,
                name: product.name,
                stock: product.stock,
                price: precioUnitario,
                quantity: cantidad,
                real_cost: product.real_cost
            });
            renderProductsTableCrear();
            $('#product-search').val(null).trigger('change');
        });

        function renderProductsTableCrear() {
            const tbody = document.querySelector('#products-table tbody');
            tbody.innerHTML = '';
            productsAddedCrear.forEach((product, idx) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <input type="hidden" name="products[${idx}][product_id]" value="${product.id}">
                        ${product.name}
                    </td>
                    <td>
                        <input type="number" name="products[${idx}][quantity]" value="${product.quantity}" min="1" max="${product.stock}" class="form-control form-control-sm quantity-input" data-idx="${idx}">
                    </td>
                    <td>${product.stock}</td>
                    <td>${typeof product.real_cost !== 'undefined' && product.real_cost !== null ? '$' + parseFloat(product.real_cost).toFixed(2) : '-'}</td>
                    <td><input type="number" name="products[${idx}][price]" value="${product.price}" min="0" class="form-control form-control-sm price-input" data-idx="${idx}"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-product" data-idx="${idx}">Eliminar</button></td>
                `;
                tbody.appendChild(tr);
            });
        }

        document.querySelector('#products-table').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-product')) {
                const idx = e.target.getAttribute('data-idx');
                productsAddedCrear.splice(idx, 1);
                renderProductsTableCrear();
            }
        });

        document.querySelector('#products-table').addEventListener('change', function (e) {
            if (e.target.classList.contains('quantity-input')) {
                const idx = e.target.getAttribute('data-idx');
                let value = parseInt(e.target.value);
                if (isNaN(value) || value < 1) value = 1;
                if (value > productsAddedCrear[idx].stock) value = productsAddedCrear[idx].stock;
                productsAddedCrear[idx].quantity = value;
                e.target.value = value;
            }
        });

        document.getElementById('saleForm').addEventListener('submit', function (e) {
            e.preventDefault();
            document.querySelectorAll('.price-input').forEach(function(input) {
                const idx = input.getAttribute('data-idx');
                if (productsAddedCrear[idx]) {
                    productsAddedCrear[idx].price = parseFloat(input.value);
                }
            });
            if (productsAddedCrear.length === 0) {
                alert('Debe agregar al menos un producto a la venta');
                return;
            }
            const formData = new FormData(this);
            productsAddedCrear.forEach((product, idx) => {
                formData.append(`products[${idx}][product_id]`, product.id);
                formData.append(`products[${idx}][quantity]`, product.quantity);
                formData.append(`products[${idx}][price]`, product.price);
            });
            if (window.adminUnlockKey) {
                formData.append('admin_unlock_key', window.adminUnlockKey);
            }
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(async response => {
                let data;
                try { data = await response.json(); } catch { data = {}; }
                if (!response.ok) {
                    if (data.authorization_required) {
                        showAuthorizationLinkCrear(data.invalid_products);
                        return;
                    }
                    throw new Error(data.message || 'Error en la respuesta del servidor');
                }
                return data;
            })
            .then(data => {
                if (!data) return;
                if (data.success) {
                    window.location.href = data.redirect || '/admin/sales';
                } else if (data.authorization_required) {
                    showAuthorizationLinkCrear(data.invalid_products);
                } else {
                    alert(data.message || 'Error al crear la venta');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la venta. Por favor, intente nuevamente.');
            });
        });

        function showAuthorizationLinkCrear(invalidProducts) {
            if (document.getElementById('authorization-link')) return;
            const form = document.getElementById('saleForm');
            const submitRow = form.querySelector('.row.g-4.mt-2 .btn-success').parentElement;
            const authDiv = document.createElement('div');
            authDiv.className = 'mt-2';
            let invalidProductsHtml = '';
            if (invalidProducts && invalidProducts.length > 0) {
                invalidProductsHtml = '<div class="alert alert-warning mt-2">';
                invalidProductsHtml += '<strong>Productos con precio inválido:</strong><ul>';
                invalidProducts.forEach(product => {
                    invalidProductsHtml += `<li>${product.name}: Precio actual ($${product.unit_price}) es menor o igual al costo real ($${product.real_cost})</li>`;
                });
                invalidProductsHtml += '</ul></div>';
            }
            authDiv.innerHTML = `
                ${invalidProductsHtml}
                Pedir autorización para venta bajo costo real<a href="#" id="authorization-link" class="ink-underline-primary"> Autorizar </a>
            `;
            submitRow.insertBefore(authDiv, submitRow.firstChild);
            document.getElementById('authorization-link').addEventListener('click', function(e) {
                e.preventDefault();
                showAuthorizationModal();
            });
        }
        function showAuthorizationModal() {
            if (document.getElementById('authorization-modal')) return;
            const modal = document.createElement('div');
            modal.id = 'authorization-modal';
            modal.style.position = 'fixed';
            modal.style.top = '0';
            modal.style.left = '0';
            modal.style.width = '100vw';
            modal.style.height = '100vh';
            modal.style.background = 'rgba(0,0,0,0.5)';
            modal.style.display = 'flex';
            modal.style.alignItems = 'center';
            modal.style.justifyContent = 'center';
            modal.innerHTML = `
                <div style="background:#fff;padding:30px;border-radius:8px;min-width:300px;max-width:90vw;">
                    <h5>Autorización requerida</h5>
                    <p>Ingrese la clave de autorización de administrador:</p>
                    <input type="password" id="admin-unlock-key-input" class="form-control mb-2" placeholder="Clave de administrador">
                    <div id="admin-unlock-error" style="color:red;display:none;"></div>
                    <button id="admin-unlock-submit" class="btn btn-primary">Desbloquear</button>
                    <button id="admin-unlock-cancel" class="btn btn-secondary ms-2">Cancelar</button>
                </div>
            `;
            document.body.appendChild(modal);
            document.getElementById('admin-unlock-cancel').onclick = function() {
                modal.remove();
            };
            document.getElementById('admin-unlock-submit').onclick = function() {
                const key = document.getElementById('admin-unlock-key-input').value;
                if (!key) {
                    document.getElementById('admin-unlock-error').textContent = 'Debe ingresar una clave.';
                    document.getElementById('admin-unlock-error').style.display = 'block';
                    return;
                }
                // Validar clave por AJAX
                fetch('/api/admin-unlock-key/validate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ key })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.valid) {
                        window.adminUnlockKey = key;
                        modal.remove();
                        // Reintentar submit
                        document.getElementById('saleForm').dispatchEvent(new Event('submit'));
                    } else {
                        document.getElementById('admin-unlock-error').textContent = 'Clave incorrecta.';
                        document.getElementById('admin-unlock-error').style.display = 'block';
                    }
                })
                .catch(() => {
                    document.getElementById('admin-unlock-error').textContent = 'Error validando la clave.';
                    document.getElementById('admin-unlock-error').style.display = 'block';
                });
            };
        }
    }

    // --- MÓDULO DE VENTAS: EDICIÓN ---
    if (window.saleData && document.getElementById('saleForm')) {
        let clienteSeleccionadoEditar = { role: window.saleData.clientRole };
        let productsAddedEditar = [];
        function obtenerPrecioPorRolEditar(producto, role) {
            if (role === 'Cliente mayorista') {
                return producto.precio_mayorista;
            } else if (role === 'Cliente instalador') {
                return producto.precio_instalador;
            } else {
                return producto.precio_publico;
            }
        }
        if (window.saleData.existingProducts && window.saleData.existingProducts.length > 0) {
            productsAddedEditar = [...window.saleData.existingProducts];
            renderProductsTableEditar();
        }
        $('#client-search').select2({
            placeholder: 'Buscar cliente por nombre, email o RFC',
            ajax: {
                url: '/api/clients/search',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (client) {
                            return {
                                id: client.id,
                                text: (client.name || '') + ' ' + (client.last_name || ''),
                                role: client.role || 'Cliente publico en general'
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1,
            width: '100%'
        });
        $('#product-search').select2({
            placeholder: 'Buscar producto por nombre',
            ajax: {
                url: '/api/products/search',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return {
                        results: data.map(function (product) {
                            return {
                                id: product.id,
                                name: product.name,
                                text: product.name,
                                stock: product.stock,
                                precio_publico: product.precio_publico,
                                precio_mayorista: product.precio_mayorista,
                                precio_instalador: product.precio_instalador,
                                real_cost: product.real_cost
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1,
            width: '100%'
        });
        document.getElementById('add-product').addEventListener('click', function() {
            const select2Data = $('#product-search').select2('data')[0];
            if (!select2Data) {
                alert('Seleccione un producto');
                return;
            }
            let cantidad = pedirCantidad(select2Data.stock);
            if (!cantidad) return;
            const product = {
                id: select2Data.id,
                name: select2Data.name || select2Data.text,
                stock: select2Data.stock,
                price: obtenerPrecioPorRolEditar(select2Data, clienteSeleccionadoEditar.role),
                quantity: cantidad,
                real_cost: select2Data.real_cost !== undefined ? select2Data.real_cost : (select2Data.realCost !== undefined ? select2Data.realCost : 0)
            };
            if (productsAddedEditar.find(p => p.id == product.id)) {
                alert('Este producto ya fue agregado');
                return;
            }
            productsAddedEditar.push(product);
            renderProductsTableEditar();
            $('#product-search').val(null).trigger('change');
        });
        function renderProductsTableEditar() {
            const tbody = document.querySelector('#products-table tbody');
            tbody.innerHTML = '';
            productsAddedEditar.forEach((product, idx) => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>
                        <input type="hidden" name="products[${idx}][product_id]" value="${product.id}">
                        ${product.name}
                    </td>
                    <td>
                        <input type="number" name="products[${idx}][quantity]" value="${product.quantity}" min="1" max="${product.stock}" class="form-control form-control-sm quantity-input" data-idx="${idx}">
                    </td>
                    <td>${product.stock}</td>
                    <td>${typeof product.real_cost !== 'undefined' && product.real_cost !== null ? '$' + parseFloat(product.real_cost).toFixed(2) : '-'}</td>
                    <td><input type="number" name="products[${idx}][price]" value="${product.price}" min="0" step="0.01" class="form-control form-control-sm price-input" data-idx="${idx}"></td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-product" data-idx="${idx}">Eliminar</button></td>
                `;
                tbody.appendChild(tr);
            });
        }
        document.querySelector('#products-table').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-product')) {
                const idx = e.target.getAttribute('data-idx');
                productsAddedEditar.splice(idx, 1);
                renderProductsTableEditar();
            }
        });
        document.querySelector('#products-table').addEventListener('change', function(e) {
            if (e.target.classList.contains('quantity-input')) {
                const idx = e.target.getAttribute('data-idx');
                let value = parseInt(e.target.value);
                if (isNaN(value) || value < 1) value = 1;
                if (value > productsAddedEditar[idx].stock) value = productsAddedEditar[idx].stock;
                productsAddedEditar[idx].quantity = value;
                e.target.value = value;
            }
            if (e.target.classList.contains('price-input')) {
                const idx = e.target.getAttribute('data-idx');
                let value = parseFloat(e.target.value);
                if (isNaN(value) || value < 0) value = 0;
                productsAddedEditar[idx].price = value;
            }
        });
        document.getElementById('saleForm').addEventListener('submit', function(e) {
            e.preventDefault();
            document.querySelectorAll('.price-input').forEach(function(input) {
                const idx = input.getAttribute('data-idx');
                if (productsAddedEditar[idx]) {
                    productsAddedEditar[idx].price = parseFloat(input.value);
                }
            });
            if (productsAddedEditar.length === 0) {
                alert('Debe agregar al menos un producto a la venta');
                return;
            }
            const formData = new FormData(this);
            productsAddedEditar.forEach((product, idx) => {
                formData.append(`products[${idx}][product_id]`, product.id);
                formData.append(`products[${idx}][quantity]`, product.quantity);
                formData.append(`products[${idx}][price]`, product.price);
            });
            if (window.adminUnlockKey) {
                formData.append('admin_unlock_key', window.adminUnlockKey);
            }
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(async response => {
                let data;
                try { data = await response.json(); } catch { data = {}; }
                if (!response.ok) {
                    if (data.authorization_required) {
                        showAuthorizationLinkEditar(data.invalid_products);
                        return;
                    }
                    throw new Error(data.message || 'Error en la respuesta del servidor');
                }
                return data;
            })
            .then(data => {
                if (!data) return;
                if (data.success) {
                    window.location.href = data.redirect || '/admin/sales';
                } else if (data.authorization_required) {
                    showAuthorizationLinkEditar(data.invalid_products);
                } else {
                    alert(data.message || 'Error al actualizar la venta');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la venta. Por favor, intente nuevamente.');
            });
        });
        function showAuthorizationLinkEditar(invalidProducts) {
            if (document.getElementById('authorization-link')) return;
            const form = document.getElementById('saleForm');
            const submitRow = form.querySelector('.row.g-4.mt-2 .btn-success').parentElement;
            const authDiv = document.createElement('div');
            authDiv.className = 'mt-2';
            let invalidProductsHtml = '';
            if (invalidProducts && invalidProducts.length > 0) {
                invalidProductsHtml = '<div class="alert alert-warning mt-2">';
                invalidProductsHtml += '<strong>Productos con precio inválido:</strong><ul>';
                invalidProducts.forEach(product => {
                    invalidProductsHtml += `<li>${product.name}: Precio actual ($${product.unit_price}) es menor o igual al costo real ($${product.real_cost})</li>`;
                });
                invalidProductsHtml += '</ul></div>';
            }
            authDiv.innerHTML = `
                ${invalidProductsHtml}
                Pedir autorización para venta bajo costo real<a href="#" id="authorization-link" class="ink-underline-primary"> Autorizar </a>
            `;
            submitRow.insertBefore(authDiv, submitRow.firstChild);
            document.getElementById('authorization-link').addEventListener('click', function(e) {
                e.preventDefault();
                showAuthorizationModal();
            });
        }
    }

    // Inicializar Select2 para búsqueda de productos (forzado con setTimeout para asegurar que el select esté en el DOM)
    setTimeout(function() {
        if ($('#product_id').length) {
            console.log('Inicializando Select2 para #product_id');
            $('#product_id').select2({
                placeholder: 'Buscar producto...',
                allowClear: true,
                ajax: {
                    url: '/api/products/search',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return { q: params.term };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return { id: item.id, text: item.name };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
                width: '100%'
            });
        } else {
            console.log('No se encontró #product_id al inicializar Select2');
        }
    }, 1000);

    // Inicializar Select2 para búsqueda de productos (forzado con setTimeout para asegurar que el select esté en el DOM)
    setTimeout(function() {
        if ($('#warehouse_product_id').length) {
            console.log('Inicializando Select2 para #product_id');
            $('#warehouse_product_id').select2({
                placeholder: 'Buscar producto...',
                allowClear: true,
                ajax: {
                    url: '/api/products/all/search',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return { q: params.term };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return { id: item.id, text: item.name };
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1,
                width: '100%'
            });
        } else {
            console.log('No se encontró #product_id al inicializar Select2');
        }
    }, 1000);

    // File transfer preview and handling
    if (document.getElementById('file_transfer')) {
        const fileInput = document.getElementById('file_transfer');
        const filePreview = document.getElementById('file-preview');
        const previewImage = document.getElementById('preview-image');
        const previewPdf = document.getElementById('preview-pdf');

        fileInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const fileType = file.type;
                
                filePreview.style.display = 'block';
                
                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                        previewPdf.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                } else if (fileType === 'application/pdf') {
                    previewImage.style.display = 'none';
                    previewPdf.style.display = 'block';
                    previewPdf.querySelector('a').href = URL.createObjectURL(file);
                }
            } else {
                filePreview.style.display = 'none';
            }
        });
    }

    // Function to delete file
    window.deleteFile = function() {
        if (confirm('¿Está seguro de eliminar el comprobante de pago?')) {
            // Obtener el ID de la venta de la URL actual (el número antes de /edit)
            const pathParts = window.location.pathname.split('/');
            const editIndex = pathParts.indexOf('edit');
            const saleId = pathParts[editIndex - 1];
            
            axios.post(`/admin/sales/${saleId}/delete-file`, {}, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (response.data.success) {
                    location.reload();
                } else {
                    alert('Error al eliminar el archivo');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar el archivo');
            });
        }
    }
});

