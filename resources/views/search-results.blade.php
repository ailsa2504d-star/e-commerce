@extends('layouts.app')

@section('content')
<h2 class="mb-4 text-center">Search Results</h2>

<div class="card p-4 mb-4 bg-light">
    <form action="{{ route('product.search') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" value="{{ request('name') }}" placeholder="Product name...">
        </div>
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                <option value="Art Supplies" {{ request('category') == 'Art Supplies' ? 'selected' : '' }}>Art Supplies</option>
                <option value="Stationery" {{ request('category') == 'Stationery' ? 'selected' : '' }}>Stationery</option>
                <option value="Gifts" {{ request('category') == 'Gifts' ? 'selected' : '' }}>Gifts</option>
            </select>
        </div>
        <div class="col-md-2">
            <input type="number" name="min_price" class="form-control" value="{{ request('min_price') }}" placeholder="Min $">
        </div>
        <div class="col-md-2">
            <input type="number" name="max_price" class="form-control" value="{{ request('max_price') }}" placeholder="Max $">
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100">Find</button>
        </div>
    </form>
</div>

<div class="row g-4">
    @forelse($products as $product)
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
    @empty
    <div class="col-12 text-center py-5">
        <p class="text-muted">No products found matching your search.</p>
        <a href="{{ route('shop') }}" class="btn btn-outline-secondary">Show all products</a>
    </div>
    @endforelse
</div>
@endsection
