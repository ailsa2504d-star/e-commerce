@extends('layouts.app')

@section('content')
<h2 class="mb-4 text-center">Checkout</h2>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card p-4">
            <h5 class="mb-4">Order Details</h5>
            <ul class="list-group mb-4">
                @foreach($cart as $details)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $details['name'] }} (x{{ $details['quantity'] }})
                    <span>${{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between align-items-center bg-light fw-bold">
                    Total
                    <span>${{ number_format($total, 2) }}</span>
                </li>
            </ul>

            <form action="{{ route('order.place') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <h5>Delivery Options</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="delivery_type" id="normal" value="normal" checked>
                        <label class="form-check-link" for="normal">Normal Delivery (Free)</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="delivery_type" id="fast" value="fast">
                        <label class="form-check-link" for="fast">Fast Delivery (+$5.00)</label>
                    </div>
                </div>

                <div class="mb-4">
                    <h5>Payment Method</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_type" id="cc" value="Credit Card" checked>
                        <label class="form-check-link" for="cc">Credit Card</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_type" id="cheque" value="Cheque">
                        <label class="form-check-link" for="cheque">Cheque</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="payment_type" id="vpp" value="VPP">
                        <label class="form-check-link" for="vpp">VPP (Cash on Delivery)</label>
                    </div>
                </div>

                <div class="alert alert-info py-2 small">
                    <i class="bi bi-info-circle"></i> 
                    Credit Card & Cheque payments must be cleared before dispatch.
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100">Place Order</button>
            </form>
        </div>
    </div>
</div>
@endsection
