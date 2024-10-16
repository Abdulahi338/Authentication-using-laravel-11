{{-- resources/views/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>User Dashboard</title>
</head>
<body>
    <div class="container mt-5">
        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Welcome, {{ $user->name }}</h1>
                <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>

                <div class="d-flex gap-2 mb-3">
                    <a href="{{ url('/posts/create') }}" class="btn btn-primary">Create Post</a>
                    <a href="{{ url('/posts') }}" class="btn btn-secondary">Go to Posts</a>
                </div>

                <form action="{{ url('/logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
