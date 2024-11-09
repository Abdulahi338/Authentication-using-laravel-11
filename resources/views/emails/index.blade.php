@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">{{ __('Emails') }}</h1>
    </div>

    @if(session('message'))
        <div class="alert alert-info text-center">{{ session('message') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('emails.create') }}" class="btn btn-primary">Create New Email</a>
    </div>

    <h3>Incoming Emails</h3>
    @forelse ($incomingEmails as $email)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $email->subject }}</h5>
                <p class="card-text">{{ $email->content }}</p>
                <p class="card-text"><small class="text-muted">From: {{ $email->from }}</small></p>
                <form action="{{ route('emails.destroy', $email) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <div class="alert alert-light text-center border rounded p-4">
            <h5>No Incoming Emails</h5>
        </div>
    @endforelse

    <hr>

    <h3>Outgoing Emails</h3>
    @forelse ($outgoingEmails as $email)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $email->subject }}</h5>
                <p class="card-text">{{ $email->content }}</p>
                <p class="card-text"><small class="text-muted">To: {{ $email->to }}</small></p>
            </div>
        </div>
    @empty
        <div class="alert alert-light text-center border rounded p-4">
            <h5>No Outgoing Emails</h5>
        </div>
    @endforelse
</div>
@endsection
