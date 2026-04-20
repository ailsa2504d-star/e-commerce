@extends('layouts.app')

@section('content')
<div class="row mb-5 align-items-center">
    <div class="col-md-6">
        <h1 class="display-4 fw-bold" style="color: var(--primary-color);">Discover Artistic Excellence</h1>
        <p class="lead">Premium stationery, art supplies, and unique gifts for your creative journey.</p>
        <a href="{{ route('shop') }}" class="btn btn-primary btn-lg mt-3">Explore Shop</a>
    </div>
    <div class="col-md-6">
        <img src="https://images.unsplash.com/photo-1513364776144-60967b0f800f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Art Supplies" class="img-fluid rounded-shadow border-radius-20" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    </div>
</div>

<h2 class="text-center mb-4" style="color: var(--text-color);">Featured Products</h2>
<div class="row g-4">
    @foreach($featuredProducts as $product)
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <span class="badge badge-custom mb-2">{{ $product->category }}</span>
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text text-muted small">{{ Str::limit($product->description, 60) }}</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="fw-bold text-dark">${{ number_format($product->price, 2) }}</span>
                    <a href="{{ route('product.show', $product->id) }}" class="btn btn-sm btn-outline-primary">View</a>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0 pb-3">
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
