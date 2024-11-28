@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="lead">Here you can view your profile and manage your emails.</p>
    </div>

    <!-- Profile Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Your Profile</h3>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Member Since:</strong> {{ auth()->user()->created_at->format('F j, Y') }}</p>
        </div>
    </div>

    <!-- Emails Section -->
    <div class="card">
        <div class="card-header">
            <h3>Your Emails</h3>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-3">
                <h5>Incoming Emails</h5>
                <a href="{{ route('emails.create') }}" class="btn btn-primary">Create New Email</a>
            </div>
            @if ($incomingEmails->isEmpty() && $outgoingEmails->isEmpty())
                <p class="text-muted">No emails to display.</p>
            @else
                <div class="row">
                    <div class="col-md-6">
                        <h6>Incoming Emails</h6>
                        <ul class="list-group">
                            @foreach ($incomingEmails as $email)
                                <li class="list-group-item">
                                    <strong>From:</strong> {{ $email->from }} <br>
                                    <strong>Subject:</strong> {{ $email->subject }} <br>
                                    <small class="text-muted">{{ $email->created_at->diffForHumans() }}</small>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Outgoing Emails</h6>
                        <ul class="list-group">
                            @foreach ($outgoingEmails as $email)
                                <li class="list-group-item">
                                    <strong>To:</strong> {{ $email->to }} <br>
                                    <strong>Subject:</strong> {{ $email->subject }} <br>
                                    <small class="text-muted">{{ $email->created_at->diffForHumans() }}</small>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
