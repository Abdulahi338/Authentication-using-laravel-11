<!-- resources/views/emails/incoming.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Incoming Emails</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>From</th>
                <th>Subject</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incomingEmails as $email)
                <tr>
                    <td>{{ $email->from }}</td>
                    <td>{{ $email->subject }}</td>
                    <td>{{ $email->sent_at->format('M d, Y') }}</td>
                    <td>
                        <!-- Actions (e.g., view, delete, etc.) -->
                        <a href="{{ route('emails.view', $email->id) }}" class="btn btn-info">View</a>
                        <form action="{{ route('emails.destroy', $email->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
