@extends('layouts.app')

@section('content')
<h2 class="mb-4">Shopping Cart</h2>

@if(count($cart) > 0)
<div class="row">
    <div class="col-md-8">
        <div class="card p-3">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $id => $details)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $details['name'] }}</h6>
                                    <small class="text-muted">{{ $details['product_id'] }}</small>
                                </div>
                            </div>
                        </td>
                        <td>${{ number_format($details['price'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center">
                                @csrf
                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="form-control form-control-sm w-50 me-2">
                                <button type="submit" class="btn btn-sm btn-outline-secondary">Update</button>
                            </form>
                        </td>
                        <td>${{ number_format($details['price'] * $details['quantity'], 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">&times;</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card p-4">
            <h4>Order Summary</h4>
            <hr>
            <div class="d-flex justify-content-between mb-3">
                <span>Items:</span>
                <span>{{ count($cart) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="h4">Total:</span>
                <span class="h4 text-primary">${{ number_format($total, 2) }}</span>
            </div>
            <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg w-100">Proceed to Checkout</a>
        </div>
    </div>
</div>
@else
<div class="text-center py-5">
    <h3>Your cart is empty</h3>
    <a href="{{ route('shop') }}" class="btn btn-primary mt-3">Go to Shop</a>
</div>
@endif
@endsection
