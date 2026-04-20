@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Order Details</h3>
            <a href="{{ route('customer.orders') }}" class="btn btn-outline-secondary btn-sm">&larr; Back to Orders</a>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card p-4 mb-4">
                    <h5>Order ID: <span class="text-primary">{{ $order->order_id }}</span></h5>
                    <p class="text-muted">Placed on {{ $order->created_at->format('M d, Y H:i') }}</p>
                    <hr>
                    <h6 class="mb-3">Items</h6>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Quantity</th>
                                <th class="text-end">Price</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\OrderItem::where('order_id', $order->order_id)->get() as $item)
                            <tr>
                                <td>{{ $item->product_id }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-end">${{ number_format($item->price, 2) }}</td>
                                <td class="text-end">${{ number_format($item->price * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                            <tr class="fw-bold">
                                <td colspan="3" class="text-end">Total</td>
                                <td class="text-end">${{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4 mb-4">
                    <h6>Status: 
                        <span class="badge bg-info text-dark">{{ str_replace('_', ' ', strtoupper($order->status)) }}</span>
                    </h6>
                    <hr>
                    <p><strong>Payment:</strong> {{ $order->payment_type }}</p>
                    <p><strong>Delivery:</strong> {{ ucfirst($order->delivery_type) }}</p>
                    <p><strong>Shipping Address:</strong><br>
                    <span class="text-muted small">{{ Auth::user()->address ?? 'No address provided' }}</span></p>
                </div>

                @php
                    $delivery = \App\Models\Delivery::where('order_id', $order->order_id)->first();
                @endphp
                @if($delivery)
                <div class="card p-4">
                    <h6>Tracking Info</h6>
                    <hr>
                    <p><strong>Dispatch Date:</strong> {{ $delivery->dispatch_date ? $delivery->dispatch_date->format('M d, Y') : 'Pending' }}</p>
                    <p><strong>Delivery Status:</strong> {{ ucfirst($delivery->status) }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
