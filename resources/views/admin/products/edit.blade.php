@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Edit Product</h3>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Back</a>
            </div>
            
            <form action="{{ route('products.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select" required>
                            <option value="Art Supplies" {{ $product->category == 'Art Supplies' ? 'selected' : '' }}>Art Supplies</option>
                            <option value="Stationery" {{ $product->category == 'Stationery' ? 'selected' : '' }}>Stationery</option>
                            <option value="Gifts" {{ $product->category == 'Gifts' ? 'selected' : '' }}>Gifts</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Price ($)</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="{{ $product->price }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" name="stock_quantity" class="form-control" value="{{ $product->stock_quantity }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ $product->description }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Product</button>
            </form>
        </div>
    </div>
</div>
@endsection
