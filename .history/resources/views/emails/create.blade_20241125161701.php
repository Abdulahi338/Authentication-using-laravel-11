@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">{{ __('Create a New Email') }}</h1>
    </div>

    @extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">{{ __('Create a New Email') }}</h1>
    </div>
 
    <form action="{{ route('emails.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="from" class="form-label">From</label>
            <!-- Use auth()->user()->email to dynamically populate the 'from' field with the logged-in user's email -->
            <input type="email" class="form-control" id="from" name="from" value="{{ auth()->user()->email }}" readonly>
        </div>

        <div class="mb-3">
            <label for="to" class="form-label">To</label>
            <input type="email" class="form-control" id="to" name="to" placeholder="Recipient's email" required>
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="Email subject" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="4" placeholder="Write your email content here..." required></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Send Email</button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </form>
</div>
@endsection
