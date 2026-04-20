@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Employee Dashboard</h2>
    <div class="btn-group">
        <a href="{{ route('employee.password') }}" class="btn btn-outline-info btn-sm">Change Password</a>
        <form action="{{ route('employee.logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
        </form>
    </div>
</div>

<h3>Order Delivery Management</h3>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-info">
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th class="text-center">Update Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><span class="small fw-bold">{{ $order->order_id }}</span></td>
                    <td>{{ $order->user->name ?? 'Deleted User' }}</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>{{ $order->payment_type }} ({{ $order->status == 'cleared' || $order->status == 'dispatched' || $order->status == 'delivered' ? 'Paid' : 'Pending' }})</td>
                    <td>
                        <span class="badge @if($order->status == 'delivered') bg-success @elseif($order->status == 'pending') bg-warning @else bg-info @endif text-dark">
                            {{ strtoupper($order->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('employee.order.update', $order->order_id) }}" method="POST" class="d-flex justify-content-center gap-2">
                            @csrf
                            <select name="status" class="form-select form-select-sm" style="width: auto;">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="cleared" {{ $order->status == 'cleared' ? 'selected' : '' }}>Cleared</option>
                                <option value="dispatched" {{ $order->status == 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-info text-white">Update</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
