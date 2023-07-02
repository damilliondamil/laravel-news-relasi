<!-- resources/views/posts.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Posts</div>

                    <div class="card-body">
                        @foreach ($posts as $post)
                            <div class="mb-4">
                                <h4>{{ $post->title }}</h4>
                                <p>{{ $post->content }}</p>
                                <p>Author: {{ $post->user->username }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
