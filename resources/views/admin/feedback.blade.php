@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Customer Feedback</h3>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">Back to Dashboard</a>
</div>
<div class="row">
    @forelse($feedbacks as $feedback)
        <div class="col-md-6 mb-4">
            <div class="card p-3 border-left-primary">
                <div class="d-flex justify-content-between mb-2">
                    <h6 class="text-primary mb-0">{{ $feedback->user->name ?? 'Deleted User' }}</h6>
                    <small class="text-muted">{{ $feedback->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-0 italic">"{{ $feedback->message }}"</p>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">No feedback received yet.</p>
        </div>
    @endforelse
</div>
@endsection
