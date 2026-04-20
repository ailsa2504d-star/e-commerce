@extends('layouts.app')

@section('content')
<h3 class="mb-4">My Orders</h3>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Delivery</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><span class="small fw-bold">{{ $order->order_id }}</span></td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>${{ number_format($order->total_amount, 2) }}</td>
                    <td>{{ $order->payment_type }}</td>
                    <td>{{ ucfirst($order->delivery_type) }}</td>
                    <td>
                        <span class="badge @if($order->status == 'delivered') bg-success @elseif($order->status == 'cancelled') bg-danger @else bg-info @endif text-dark">
                            {{ str_replace('_', ' ', ucfirst($order->status)) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('customer.order.details', $order->order_id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                        
                        @if($order->status == 'pending' || $order->status == 'cleared')
                            <form action="{{ route('order.cancel', $order->order_id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Cancel</button>
                            </form>
                        @endif

                        @if($order->status == 'delivered' && $order->updated_at->diffInDays(now()) <= 7)
                            <form action="{{ route('order.return', $order->order_id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-warning" onclick="return confirm('Request return/replacement?')">Return</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">You haven't placed any orders yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
