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
</style>
@endsection

@section('content')
<h1>Carrito de Compras</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-error">
        <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button class="close-btn" onclick="this.parentElement.style.display='none';">&times;</button>
    </div>
@endif

@if($cart->items->isEmpty())
    <p>Tu carrito está vacío.</p>
@else
    <table>
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
            @foreach($cart->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>
                    <form action="{{ route('cart.item.update', $item->id) }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" />
                        <button type="submit">Actualizar</button>
                    </form>
                </td>
                <td>${{ number_format($item->product->price, 2) }}</td>
                <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                <td>
                    <form action="{{ route('cart.item.remove', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('cart.checkout') }}" method="POST">
        @csrf
        <button type="submit">Realizar compra</button>
    </form>
@endif

@endsection