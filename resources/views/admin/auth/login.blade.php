@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4 border-primary">
            <h3 class="text-center mb-4 text-primary">Admin Login</h3>
            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Admin Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Access Dashboard</button>
            </form>
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-muted small text-decoration-none">&larr; Back to Shop</a>
            </div>
        </div>
    </div>
</div>
@endsection
