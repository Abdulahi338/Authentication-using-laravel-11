<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Email</title>
</head>
<body>
    <div class="container">
        <h1>{{ $email->subject }}</h1>
        <p>From: {{ $email->from }}</p>
        {{-- <p>Sent At: {{ $email->sent_at->format('M d, Y') }}</p> --}}
        <div>{{ $email->content }}</div>
    </div>
</body>
</html>
