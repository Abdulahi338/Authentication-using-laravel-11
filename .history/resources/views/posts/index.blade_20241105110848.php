{{-- @extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">{{ __('Your Posts') }}</h1>
    </div>

    @if(session('message'))
        <div class="alert alert-info text-center">{{ session('message') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @forelse ($posts as $post)
        <div class="card mb-4 border-0 shadow rounded">
            <div class="card-body">
                <h3 class="card-title mb-3">{{ $post->title }}</h3>
                <p class="card-text">{{ $post->content }}</p>
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-light text-center border rounded p-4">
            <h5 class="mb-3">{{ __('No posts available') }}</h5>
            <p>{{ __('Start by creating a new post!') }}</p>
        </div>
    @endforelse

    <div class="d-flex justify-content-between align-items-center mt-5">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-dark">Back to Dashboard</a>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create Post</a>
    </div>
</div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="d-flex">
    <!-- Sidebar -->
    <nav class="bg-dark text-white vh-100 p-3" style="width: 250px;">
        <h3 class="text-center">Admin Panel</h3>
        <hr class="text-light">
        <ul class="nav flex-column">
            <li class="nav-item mb-3">
                <a href="{{ route('dashboard') }}" class="nav-link text-white">
                    <i class="fas fa-home me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="#" class="nav-link text-white">
                    <i class="fas fa-envelope me-2"></i> Incoming Emails
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="#" class="nav-link text-white">
                    <i class="fas fa-paper-plane me-2"></i> Outgoing Emails
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('posts.index') }}" class="nav-link text-white">
                    <i class="fas fa-file-alt me-2"></i> Manage Posts
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('posts.create') }}" class="nav-link text-white">
                    <i class="fas fa-plus me-2"></i> Create Post
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content Area -->
    <div class="container-fluid p-4">
        <div class="row mb-4">
            <div class="col">
                <h1 class="fw-bold">Welcome to the Admin Dashboard</h1>
                <p class="lead text-muted">Manage your posts and emails efficiently.</p>
            </div>
        </div>

        <!-- Post Management Section -->
        <div class="card border-0 shadow rounded-3 mb-5">
            <div class="card-body">
                <h2 class="mb-3"><i class="fas fa-file-alt me-2"></i> Your Posts</h2>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content Preview</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ \Illuminate\Support\Str::limit($post->content, 50, '...') }}</td>
                                    <td>{{ $post->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if($posts->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No posts available. Start by creating a new post!</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

