@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Your Posts</h1>
        @foreach ($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="card-title">{{ $post->title }}</h2>
                    <p class="card-text">{{ $post->content }}</p>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Edit</a>

                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="mt-4">
            <a class="btn btn-secondary" href="{{ route('dashboard') }}">Back to Dashboard</a>
        </div>
    </div>
@endsection
