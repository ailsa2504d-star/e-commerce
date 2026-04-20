@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4 border-info">
            <h3 class="text-center mb-4 text-info">Employee Login</h3>
            <form action="{{ route('employee.login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Employee Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-info w-100 text-white">Login to Portal</button>
            </form>
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-muted small text-decoration-none">&larr; Back to Shop</a>
            </div>
        </div>
    </div>
</div>
@endsection
