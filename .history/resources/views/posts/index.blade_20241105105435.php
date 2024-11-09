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
    <!-- Page Header -->
    <div class="text-center mb-5">
        <h1 class="fw-bold">Post Management</h1>
        <p class="lead text-muted">View and manage your posts with ease</p>
    </div>

    <!-- Post List -->
    <div class="row">
        @forelse ($posts as $post)
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <h4 class="card-title text-primary">{{ $post->title }}</h4>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($post->content, 100, '...') }}</p>
                        <p class="text-muted small">Published on: {{ $post->created_at->format('M d, Y') }}</p>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-secondary text-center">No posts available. Create your first post now!</div>
            </div>
        @endforelse
    </div>

    <!-- Action Buttons -->
    <div class="text-center mt-4">
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create New Post</a>
    </div>
</div>
@endsection

