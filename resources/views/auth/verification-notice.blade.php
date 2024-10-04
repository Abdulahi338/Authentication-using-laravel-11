{{-- resources/views/auth/verification-notice.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Email Verification</title>
</head>
<body>
    <div class="container mt-5">
        @if(session('message'))
            <div class="alert alert-info">{{ session('message') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="alert alert-warning" role="alert">
            Please verify your email address. If you didn't receive the email, you can resend it.
        </div>

        <form action="{{ route('verification.resend') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Enter your email to resend verification</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-warning">Resend Verification Email</button>
        </form>
    </div>
</body>
</html>
