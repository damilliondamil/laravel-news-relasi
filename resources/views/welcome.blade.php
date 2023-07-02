@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Post</h1>

        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createPostModal">
            Create Post
        </button>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Gambar</th>
                    <th>Deskripsi</th>
                    <th>Penulis</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id_post }}</td>
                        <td>{{ $post->judul }}</td>
                        <td>
                            <img src="{{ asset('images/' . $post->gambar) }}" alt="Gambar Post" width="100">
                        </td>
                        <td>{{ $post->deskripsi }}</td>
                        <td>{{ $post->user->profile->nama ?? '' }}</td>

                    </tr>


                @endforeach
            </tbody>
        </table>

    </div>
@endsection
