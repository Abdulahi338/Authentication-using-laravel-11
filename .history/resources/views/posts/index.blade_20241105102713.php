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
    <div class="row mb-4">
        <div class="col text-center">
            <h1 class="display-6">{{ __('Dashboard') }}</h1>
            <p class="text-muted">Manage your incoming and outgoing emails and posts</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Incoming Emails Section -->
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Incoming Emails</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <button class="btn btn-outline-primary w-100 mb-2">Add New Incoming Email</button>
                    </div>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Email Subject #1</h6>
                                <small class="text-muted">3 days ago</small>
                            </div>
                            <p class="mb-1 text-truncate">Preview content of the email goes here...</p>
                        </a>
                        <!-- More email items as needed -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Outgoing Emails Section -->
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Outgoing Emails</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <button class="btn btn-outline-secondary w-100 mb-2">Compose Outgoing Email</button>
                    </div>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Email Subject #2</h6>
                                <small class="text-muted">1 week ago</small>
                            </div>
                            <p class="mb-1 text-truncate">Preview content of the outgoing email...</p>
                        </a>
                        <!-- More email items as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <!-- Posts Section -->
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Your Posts</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="{{ route('posts.create') }}" class="btn btn-dark w-100 mb-2">Create New Post</a>
                    </div>
                    <div class="list-group">
                        @foreach ($posts as $post)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $post->title }}</h6>
                                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1 text-truncate">{{ $post->content }}</p>
                                <div class="d-flex gap-2 mt-2">
                                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($posts->isEmpty())
                        <div class="alert alert-secondary text-center mt-3">No posts available. Start by creating a new post!</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
