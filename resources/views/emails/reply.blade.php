<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Reply to Email</h2>
        <p><strong>From:</strong> {{ $email->from }}</p>
        <form action="{{ route('emails.sendReply', $email->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="to" class="form-label">To:</label>
                <input type="email" class="form-control" id="to" name="to" value="{{ $email->from }}" readonly>
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Subject:</label>
                <input type="text" class="form-control" id="subject" name="subject" value="Re: {{ $email->subject }}">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message:</label>
                <textarea class="form-control" id="message" name="message" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Reply</button>
        </form>
    </div>
</body>
</html>
