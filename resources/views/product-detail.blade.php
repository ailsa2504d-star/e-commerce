@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-6">
        <img src="https://images.unsplash.com/photo-1586075010923-2dd4570fb338?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="{{ $product->name }}" class="img-fluid rounded shadow">
    </div>
    <div class="col-md-6">
        <span class="badge badge-custom mb-2">{{ $product->category }}</span>
        <h1 class="display-5 mb-3">{{ $product->name }}</h1>
        <p class="text-muted small">Product ID: {{ $product->product_id }}</p>
        <h3 class="text-primary mb-4">${{ number_format($product->price, 2) }}</h3>
        
        <div class="mb-4">
            <h5>Description</h5>
            <p>{{ $product->description }}</p>
        </div>
        
        <p><strong>Availability:</strong> 
            @if($product->stock_quantity > 0)
                <span class="text-success">In Stock ({{ $product->stock_quantity }} units)</span>
            @else
                <span class="text-danger">Out of Stock</span>
            @endif
        </p>

        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <div class="d-flex align-items-center mb-3">
                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="form-control w-25 me-3">
                <button type="submit" class="btn btn-primary btn-lg" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                    Add to Cart
                </button>
            </div>
        </form>

        <a href="{{ route('shop') }}" class="link-secondary text-decoration-none small">&larr; Back to Shop</a>
    </div>
</div>
@endsection
