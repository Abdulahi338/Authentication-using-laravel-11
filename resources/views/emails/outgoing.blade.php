<!-- resources/views/emails/outgoing.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Outgoing Emails</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>To</th>
                <th>Subject</th>
                <th>Sent At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($outgoingEmails as $email)
                <tr>
                    <td>{{ $email->to }}</td>
                    <td>{{ $email->subject }}</td>
                    <td>{{ $email->sent_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
