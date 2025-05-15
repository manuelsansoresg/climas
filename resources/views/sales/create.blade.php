@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Nueva Venta</h5>
                </div>

                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
                        @csrf
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="client_id">Cliente</label>
                                    <select name="client_id" id="client_id" class="form-control" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->name }} {{ $client->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_method">Método de Pago</label>
                                    <select name="payment_method" id="payment_method" class="form-control" required>
                                        <option value="cash">Efectivo</option>
                                        <option value="credit_card">Tarjeta de Crédito</option>
                                        <option value="transfer">Transferencia</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_search">Buscar Producto</label>
                                    <input type="text" id="product_search" class="form-control" placeholder="Buscar por nombre o código...">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table" id="products_table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                        <th>IVA</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Products will be added here dynamically -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Totales:</strong></td>
                                        <td id="subtotal">$0.00</td>
                                        <td id="iva">$0.00</td>
                                        <td id="total">$0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="form-group mb-4">
                            <label for="notes">Notas</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('sales.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Venta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSearch = document.getElementById('product_search');
    const productsTable = document.getElementById('products_table').getElementsByTagName('tbody')[0];
    let products = [];

    // Product search with debounce
    let searchTimeout;
    productSearch.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const query = this.value;
            if (query.length >= 2) {
                searchProducts(query);
            }
        }, 300);
    });

    function searchProducts(query) {
        fetch(`/api/products/search?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    showProductResults(data);
                }
            });
    }

    function showProductResults(products) {
        const resultsDiv = document.createElement('div');
        resultsDiv.className = 'product-results';
        resultsDiv.style.position = 'absolute';
        resultsDiv.style.zIndex = '1000';
        resultsDiv.style.backgroundColor = 'white';
        resultsDiv.style.border = '1px solid #ddd';
        resultsDiv.style.maxHeight = '200px';
        resultsDiv.style.overflowY = 'auto';
        resultsDiv.style.width = productSearch.offsetWidth + 'px';

        products.forEach(product => {
            const div = document.createElement('div');
            div.className = 'p-2 border-bottom';
            div.style.cursor = 'pointer';
            div.textContent = `${product.name} - $${product.price}`;
            div.addEventListener('click', () => addProductToTable(product));
            resultsDiv.appendChild(div);
        });

        // Remove existing results
        const existingResults = document.querySelector('.product-results');
        if (existingResults) {
            existingResults.remove();
        }

        productSearch.parentNode.appendChild(resultsDiv);
    }

    function addProductToTable(product) {
        const existingRow = document.querySelector(`tr[data-product-id="${product.id}"]`);
        if (existingRow) {
            const quantityInput = existingRow.querySelector('input[type="number"]');
            quantityInput.value = parseInt(quantityInput.value) + 1;
            updateRowTotals(existingRow);
        } else {
            const row = document.createElement('tr');
            row.setAttribute('data-product-id', product.id);
            row.innerHTML = `
                <td>${product.name}</td>
                <td>
                    <input type="number" class="form-control quantity" value="1" min="1" style="width: 80px">
                </td>
                <td class="price">$${product.price}</td>
                <td class="subtotal">$${product.price}</td>
                <td class="iva">$${(product.price * product.iva / 100).toFixed(2)}</td>
                <td class="total">$${(product.price * (1 + product.iva / 100)).toFixed(2)}</td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-product">Eliminar</button>
                </td>
            `;
            productsTable.appendChild(row);

            // Add event listeners
            row.querySelector('.quantity').addEventListener('change', () => updateRowTotals(row));
            row.querySelector('.remove-product').addEventListener('click', () => row.remove());
        }

        // Clear search and results
        productSearch.value = '';
        document.querySelector('.product-results')?.remove();
        updateTotals();
    }

    function updateRowTotals(row) {
        const quantity = parseInt(row.querySelector('.quantity').value);
        const price = parseFloat(row.querySelector('.price').textContent.replace('$', ''));
        const iva = parseFloat(row.querySelector('.iva').textContent.replace('$', ''));
        
        const subtotal = price * quantity;
        const ivaTotal = iva * quantity;
        const total = subtotal + ivaTotal;

        row.querySelector('.subtotal').textContent = `$${subtotal.toFixed(2)}`;
        row.querySelector('.total').textContent = `$${total.toFixed(2)}`;

        updateTotals();
    }

    function updateTotals() {
        let subtotal = 0;
        let iva = 0;
        let total = 0;

        document.querySelectorAll('#products_table tbody tr').forEach(row => {
            subtotal += parseFloat(row.querySelector('.subtotal').textContent.replace('$', ''));
            iva += parseFloat(row.querySelector('.iva').textContent.replace('$', ''));
            total += parseFloat(row.querySelector('.total').textContent.replace('$', ''));
        });

        document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('iva').textContent = `$${iva.toFixed(2)}`;
        document.getElementById('total').textContent = `$${total.toFixed(2)}`;
    }

    // Form submission
    document.getElementById('saleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const products = [];
        document.querySelectorAll('#products_table tbody tr').forEach(row => {
            products.push({
                product_id: row.getAttribute('data-product-id'),
                quantity: parseInt(row.querySelector('.quantity').value)
            });
        });

        if (products.length === 0) {
            alert('Debe agregar al menos un producto');
            return;
        }

        // Add products to form data
        const formData = new FormData(this);
        formData.append('products', JSON.stringify(products));

        // Submit form
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        });
    });
});
</script>
@endpush

@push('styles')
<style>
.product-results {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.product-results div:hover {
    background-color: #f8f9fa;
}
</style>
@endpush
@endsection 