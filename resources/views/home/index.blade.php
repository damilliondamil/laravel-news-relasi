@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Post</h1>
    <div class="row">
        @foreach($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('storage/images/' . $post->gambar) }}" class="card-img-top" alt="Gambar Post" style="object-fit: cover; height: 300px; ">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->judul }}</h5>

                        <p class="card-text"><i class="fas fa-user"></i> {{ $post->user->profile->nama }}</p>
                        <p class="card-text"><i class="fas fa-calendar-alt"></i> {{ $post->user->profile->created_at }}</p>
                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#detailModal{{ $post->id_post }}">
                                    Detail  <i class="fas fa-arrow-right" style="color: white"></i>
                            </button>
                        </div>
                        {{-- <a href="{{ route('posts.show', $post->id_post) }}" class="btn btn-primary">Detail</a> --}}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @foreach($posts as $post)
        <div class="modal fade" id="detailModal{{ $post->id_post }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{ $post->id_post }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModalLabel{{ $post->id_post }}">Detail Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/images/' . $post->gambar) }}" class="card-img-top" alt="Gambar Post" style="object-fit: cover; height: 300px; ">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->judul }}</h5>

                                <p class="card-text"><i class="fas fa-user"></i> {{ $post->user->profile->nama }}</p>
                                <p class="card-text"><i class="fas fa-calendar-alt"></i> {{ $post->user->profile->created_at }}</p>
                                <h5>Deskripsi:</h5>
                                <p class="card-text">{{$post->deskripsi}}</p>
                                {{-- <a href="{{ route('posts.show', $post->id_post) }}" class="btn btn-primary">Detail</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
</div>
@endsection
