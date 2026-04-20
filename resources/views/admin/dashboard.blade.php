@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Admin Dashboard</h2>
    <div class="btn-group">
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">Manage Products</a>
        <a href="{{ route('admin.employees') }}" class="btn btn-outline-primary btn-sm">Manage Employees</a>
        <a href="{{ route('admin.feedback') }}" class="btn btn-outline-primary btn-sm">View Feedback</a>
        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
        </form>
    </div>
</div>

<div class="card p-4 mb-4 bg-light">
    <form action="{{ route('admin.dashboard') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Filter by Date</label>
            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Delivery Type</label>
            <select name="delivery_type" class="form-select">
                <option value="">All</option>
                <option value="normal" {{ request('delivery_type') == 'normal' ? 'selected' : '' }}>Normal</option>
                <option value="fast" {{ request('delivery_type') == 'fast' ? 'selected' : '' }}>Fast</option>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100">Filter Orders</button>
        </div>
    </form>
</div>

<h3>All Orders</h3>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-primary">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><span class="small fw-bold">{{ $order->order_id }}</span></td>
                    <td>{{ $order->user->name ?? 'Deleted User' }}</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ $order->payment_type }}</td>
                    <td>
                        <span class="badge @if($order->status == 'delivered') bg-success @elseif($order->status == 'pending') bg-warning @else bg-info @endif text-dark">
                            {{ strtoupper($order->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No orders found matching criteria.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
