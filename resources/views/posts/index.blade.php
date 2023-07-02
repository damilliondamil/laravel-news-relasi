@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Post</h1>

        <!-- Display error message -->
        @if ($errors->any())

            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 20px; right: 20px; width: 400px;">
                <div class="toast-header bg-danger">
                    <strong class="mr-auto" style="color: white">Error</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Display success message using a notification -->
        @if (session('success'))

            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="position: absolute; top: 20px; right: 20px; width: 400px;">
                <div class="toast-header bg-success">
                    <strong class="mr-auto " style="color: white">Success</strong>
                    <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if (Cookie::get('nama_role') === 'Admin')
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createPostModal">
            Create Post
        </button>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Gambar</th>
                    <th>Deskripsi</th>
                    <th>Penulis</th>
                    @if (Cookie::get('nama_role') === 'Admin')
                    <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id_post }}</td>
                        <td>{{ $post->judul }}</td>
                        <td>
                            <img src="{{ asset('storage/images/' . $post->gambar) }}" alt="Gambar Post" width="100">
                        </td>
                        <td>{{ $post->deskripsi }}</td>
                        <td>{{ $post->user->profile->nama ?? '' }}</td>
                        @if (Cookie::get('nama_role') === 'Admin')
                        <td>
                            <button type="button" class="btn btn-primary btn-sm mb-2" data-toggle="modal" data-target="#editPostModal{{ $post->id_post }}">
                                Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deletePostModal{{ $post->id_post }}">
                                Delete
                            </button>
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Modal Create Post -->
        <div class="modal fade" id="createPostModal" tabindex="-1" role="dialog" aria-labelledby="createPostModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createPostModalLabel">Create Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="id_user">User</label>
                                <select name="id_user" id="id_user" class="form-control">
                                    <option value="">-- Select User --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id_user }}" {{ old('id_user') == $user->id_user ? 'selected' : '' }}>
                                            {{ $user->user_id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="gambar">Gambar</label>
                                <input type="file" name="gambar" id="gambar" class="form-control-file" required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control" required>{{ old('deskripsi') }}</textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Edit Post -->
        @foreach($posts as $post)
        <div class="modal fade" id="editPostModal{{ $post->id_post }}" tabindex="-1" role="dialog" aria-labelledby="editPostModalLabel{{ $post->id_post }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPostModalLabel{{ $post->id_post }}">Edit Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('posts.update', $post->id_post) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="edit_judul{{ $post->id_post }}">Judul</label>
                                <input type="text" class="form-control" id="edit_judul{{ $post->id_post }}" name="judul" value="{{ $post->judul }}">
                            </div>
                            <div class="form-group">
                                <label for="edit_deskripsi{{ $post->id_post }}">Deskripsi</label>
                                <textarea class="form-control" id="edit_deskripsi{{ $post->id_post }}" name="deskripsi">{{ $post->deskripsi }}</textarea>
                            </div>
                            <div class="form-group">
                                <label  for="edit_gambar{{ $post->id_post }}">Gambar</label>
                                <br>
                                <img class="mb-3" src="{{ asset('storage/images/' . $post->gambar) }}" alt="Gambar Post" width="100">

                                <input type="file" class="form-control-file" id="edit_gambar{{ $post->id_post }}" name="gambar">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Modal Delete Post -->
        @foreach($posts as $post)
        <div class="modal fade" id="deletePostModal{{ $post->id_post }}" tabindex="-1" role="dialog" aria-labelledby="deletePostModalLabel{{ $post->id_post }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deletePostModalLabel{{ $post->id_post }}">Delete Post</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this post?</p>
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('posts.destroy', $post->id_post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach



    </div>
    <!-- Include the necessary JavaScript -->

    <script>
         // Activate the toasts
        $(document).ready(function() {
            $('.toast').toast('show');
        });
    </script>
@endsection
