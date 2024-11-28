<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Email</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icons (Font Awesome) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .email-header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            border-radius: 5px 5px 0 0;
        }
        .email-content {
            padding: 20px;
        }
        .email-footer {
            text-align: right;
            padding: 15px;
            border-top: 1px solid #e9ecef;
        }
        .email-card {
            max-width: 700px;
            margin: 50px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Email Card -->
        <div class="card email-card">
            <!-- Header -->
            <div class="email-header">
                <h2 class="mb-0">{{ $email->subject }}</h2>
                <p class="mb-0 small">From: <strong>{{ $email->from }}</strong></p>
                {{-- <p class="mb-0 small">Sent At: {{ $email->sent_at->format('M d, Y') }}</p> --}}
            </div>

            <!-- Content -->
            <div class="email-content">
                <p>{{ $email->content }}</p>
            </div>

            <!-- Footer -->
            <div class="email-footer">
                <a href="{{ route('emails.incoming') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to Inbox
                </a>
                <a href="{{ route('emails.reply', $email->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-reply me-1"></i> Reply
                </a>
                <form action="{{ route('emails.destroy', $email->id) }}" method="POST" class="d-inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
