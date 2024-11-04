@extends('layouts.app')

@section('content')
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
            <a class="btn btn-secondary" href="{{ route('posts.create') }}">Create Posts</a>
        </div>
    </div>
@endsection
