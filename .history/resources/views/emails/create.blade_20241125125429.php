@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">{{ __('Create a New Email') }}</h1>
    </div>

    <form action="{{ route('emails.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="to" class="form-label">From</label>
            <input type="email" class="form-control" id="to" name="to" required>
        </div>
        <div class="mb-3">
            <label for="to" class="form-label">To</label>
            <input type="email" class="form-control" id="to" name="to" required>
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send Email</button>
        <button type="submit" class="btn btn-primary "><a class="btn btn-primary" href="{{ route('dashboard') }}">Back to Dashboard</a></button>
    </form>
</div>
@endsection
