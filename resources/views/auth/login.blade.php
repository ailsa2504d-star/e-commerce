@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4">
            <h3 class="text-center mb-4">Customer Login</h3>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <div class="text-center mt-3">
                <p class="small">Don't have an account? <a href="{{ route('register') }}" class="text-primary decoration-none">Register here</a></p>
                <hr>
                <p class="small text-muted">Portal access: 
                    <a href="{{ route('admin.login') }}" class="text-secondary decoration-none">Admin</a> | 
                    <a href="{{ route('employee.login') }}" class="text-secondary decoration-none">Employee</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
