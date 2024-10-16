<!-- resources/views/posts/create.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>Create a New Post</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div>
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}">
        </div>

        <div>
            <label for="content">Content:</label>
            <textarea name="content" id="content">{{ old('content') }}</textarea>
        </div>

        <div>
            <button type="submit">Create Post</button>
        </div>
    </form>
@endsection
