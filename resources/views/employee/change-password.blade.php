@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 border-info">
            <h3 class="mb-4">Change Password</h3>
            <form action="{{ route('employee.password') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                    @error('current_password')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-info w-100 text-white">Update Password</button>
            </form>
            <div class="text-center mt-3">
                <a href="{{ route('employee.dashboard') }}" class="text-muted small">&larr; Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection
