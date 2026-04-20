@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Product Management</h3>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm me-2">Back to Dashboard</a>
        <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">Add New Product</a>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td><code class="text-primary">{{ $product->product_id }}</code></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>
                        <span class="@if($product->stock_quantity < 10) text-danger fw-bold @endif">
                            {{ $product->stock_quantity }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        if(confirm('Delete this product?')) {
            this.closest('form').submit();
        }
    });
});
</script>
@endsection
