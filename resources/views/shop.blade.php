@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card mb-4 p-3">
            <h5 class="mb-3">Categories</h5>
            <ul class="list-unstyled">
                <li><a href="{{ route('shop') }}" class="text-decoration-none text-muted">All</a></li>
                <li><a href="{{ route('shop', ['category' => 'Art Supplies']) }}" class="text-decoration-none text-muted">Art Supplies</a></li>
                <li><a href="{{ route('shop', ['category' => 'Stationery']) }}" class="text-decoration-none text-muted">Stationery</a></li>
                <li><a href="{{ route('shop', ['category' => 'Gifts']) }}" class="text-decoration-none text-muted">Gifts</a></li>
            </ul>
        </div>
        
        <div class="card p-3">
            <h5 class="mb-3">Search</h5>
            <form action="{{ route('product.search') }}" method="GET">
                <input type="text" name="name" class="form-control mb-2" placeholder="Product name...">
                <button type="submit" class="btn btn-primary btn-sm w-100">Search</button>
            </form>
        </div>
    </div>
    
    <div class="col-md-9">
        <h2 class="mb-4">Our Collection</h2>
        <div class="row g-4">
            @forelse($products as $product)
            <div class="col-md-4">
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
            @empty
            <div class="col-12 text-center">
                <p>No products found.</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
