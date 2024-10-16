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
        <h1>Welcome, {{ $user->name }}</h1>
        <p>Email: {{ $user->email }}</p>
    

        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary"><a class="nav-link" href="{{ url('/posts/create') }}">Cresate posts</a></button>
            <button type="submit" class="btn btn-primary"><a class="nav-link" href="{{ url('/posts/create') }}">Cresate posts</a></button>
            

            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</body>
</html>
