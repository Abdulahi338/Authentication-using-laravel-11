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
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">{{ __('Dashboard') }}</h1>
        <p class="lead text-muted">Manage your incoming and outgoing emails, as well as your posts, in one place</p>
    </div>

    <div class="row g-4">
        <!-- Incoming Emails Card -->
        <div class="col-md-6">
            <div class="card border-0 shadow rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0 text-primary">Incoming Emails</h4>
                        <button class="btn btn-sm btn-primary rounded-pill">Add New</button>
                    </div>
                    <hr class="my-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Email Subject #1</div>
                                <small class="text-muted">Preview content of the email...</small>
                            </div>
                            <span class="badge bg-secondary rounded-pill">3d ago</span>
                        </li>
                        <!-- Add more email items as needed -->
                    </ul>
                </div>
            </div>
        </div>

        <!-- Outgoing Emails Card -->
        <div class="col-md-6">
            <div class="card border-0 shadow rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0 text-secondary">Outgoing Emails</h4>
                        <button class="btn btn-sm btn-secondary rounded-pill">Compose</button>
                    </div>
                    <hr class="my-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Email Subject #2</div>
                                <small class="text-muted">Preview of the outgoing email...</small>
                            </div>
                            <span class="badge bg-secondary rounded-pill">1w ago</span>
                        </li>
                        <!-- Add more email items as needed -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <!-- Posts Management Card -->
        <div class="col-12">
            <div class="card border-0 shadow rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0 text-dark">Your Posts</h4>
                        <a href="{{ route('posts.create') }}" class="btn btn-sm btn-dark rounded-pill">Create New Post</a>
                    </div>
                    <hr class="my-2">
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
                                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-warning rounded-pill">Edit</a>
                                                <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">Delete</button>
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

    <div class="d-flex justify-content-center mt-5">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary rounded-pill mx-2">Back to Dashboard</a>
    </div>
</div>
@endsection

