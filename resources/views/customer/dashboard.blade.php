@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card p-4 text-center mb-4">
            <div class="mb-3">
                <div class="bg-light rounded-circle d-inline-block p-4">
                    <h2 class="mb-0">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</h2>
                </div>
            </div>
            <h4>{{ Auth::user()->name }}</h4>
            <p class="text-muted">{{ Auth::user()->email }}</p>
            <hr>
            <a href="{{ route('customer.orders') }}" class="btn btn-outline-primary w-100 mb-2">My Orders</a>
        </div>

        <div class="card p-4">
            <h5>Submit Feedback</h5>
            <form action="{{ route('feedback.submit') }}" method="POST">
                @csrf
                <textarea name="message" class="form-control mb-3" rows="3" placeholder="How was your experience?" required></textarea>
                <button type="submit" class="btn btn-primary btn-sm w-100">Submit</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <h3 class="mb-4">Recent Orders</h3>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr>
                            <td><span class="small fw-bold">{{ $order->order_id }}</span></td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                <span class="badge @if($order->status == 'delivered') bg-success @elseif($order->status == 'cancelled') bg-danger @else bg-info @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('customer.order.details', $order->order_id) }}" class="btn btn-sm btn-outline-secondary">Details</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No recent orders.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
