@extends('layouts.app')

@section('styles')
    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            position: relative;
            font-weight: 600;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert .close-btn {
            position: absolute;
            top: 8px;
            right: 12px;
            cursor: pointer;
            font-weight: bold;
            font-size: 18px;
            line-height: 1;
            color: inherit;
            background: transparent;
            border: none;
        }

        .stock-info {
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .stock-warning {
            color: #dc3545;
        }

        .stock-ok {
            color: #28a745;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-input {
            width: 70px !important;
        }

        .stock-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="container min-vh-75 d-flex flex-column justify-content-center">
        <div class="row flex-grow-1 d-flex align-items-center">
            <div class="card w-100">
                <div class="card-body">
                    <h1 class="text-center mb-4">Carrito de Compras</h1>
                    @if (session('success'))
                    <div class="alert alert-success position-relative">
                        {{ session('success') }}
                        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-error position-relative">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
                    </div>
                    @endif

                    @if ($cart->items->isEmpty())
                        <p class="text-center">Tu carrito está vacío.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio unitario</th>
                                    <th>Subtotal</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>
                                            <form action="{{ route('cart.item.update', $item->id) }}" method="POST" class="quantity-form d-flex flex-column align-items-start gap-1">
                                                @csrf
                                                <div class="d-flex align-items-center gap-2">
                                                    <input type="number"
                                                        name="quantity"
                                                        value="{{ $item->quantity }}"
                                                        min="1"
                                                        max="{{ (int) $item->product->stock }}"
                                                        class="form-control form-control-sm quantity-input"
                                                        data-product-id="{{ $item->product->id }}"
                                                        data-current-stock="{{ (int) $item->product->stock }}"
                                                        autocomplete="off"
                                                        style="width: 70px;" />
                                                    <button type="submit" class="btn btn-primary btn-sm update-btn">Actualizar</button>
                                                    <span class="badge rounded-pill bg-secondary stock-badge" style="font-size: 1em;">
                                                        Stock: <span class="stock-value">{{ (int) $item->product->stock }}</span>
                                                    </span>
                                                </div>
                                                <span class="stock-warning d-none text-danger" style="font-size:0.95em;">
                                                    La cantidad solicitada excede el stock disponible
                                                </span>
                                            </form>
                                        </td>
                                        <td>${{ number_format($item->product->getPriceForUser(), 2) }}</td>
                                        <td>${{ number_format($item->product->getPriceForUser() * $item->quantity, 2) }}</td>
                                        <td>
                                            <form action="{{ route('cart.item.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <form action="{{ route('cart.checkout') }}" method="POST" class="text-center">
                            @csrf
                            <button type="submit" class="btn btn-success">Realizar compra</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
