@extends('layouts.app')

@section('content')
    <h1>Your Posts</h1>
    @foreach ($posts as $post)
        <div>
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->content }}</p>
            <a href="{{ route('posts.edit', $post) }}">Edit</a>

            <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
                <button type="submit" class="btn btn-primary"><a class="nav-link" href="{{ url('/da') }}">Cresate posts</a></button>

            </form>
        </div>
    @endforeach
@endsection
