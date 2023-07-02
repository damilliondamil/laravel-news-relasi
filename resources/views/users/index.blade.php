@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar User</h1>

        @if (Cookie::get('nama_role') === 'Admin')
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createUserModal">
            Create User
        </button>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Role</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Nomor Telepon</th>
                    @if (Cookie::get('nama_role') === 'Admin')
                    <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id_user }}</td>
                        <td>{{ $user->user_id }}</td>
                        <td>{{ $user->role->nama_role }}</td>
                        <td>{{ $user->profile->nama ?? '' }}</td>
                        <td>{{ $user->profile->alamat ?? '' }}</td>
                        <td>{{ $user->profile->no_telp ?? '' }}</td>
                        @if (Cookie::get('nama_role') === 'Admin')
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editUserModal{{ $user->id_user }}">
                                Edit
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUserModal{{ $user->id_user }}">
                                Delete
                            </button>
                        </td>
                        @endif
                    </tr>
                    <!-- Edit User Modal -->
                    <div class="modal fade" id="editUserModal{{ $user->id_user }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel{{ $user->id_user }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel{{ $user->id_user }}">Edit User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Edit User Form -->
                                    <form action="{{ route('users.update', $user->id_user) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="editPassword{{ $user->id_user }}">Password</label>
                                            <input type="password" class="form-control" id="editPassword{{ $user->id_user }}" name="password" value="{{ $user->password }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="editRole{{ $user->id_user }}">Role</label>
                                            <select class="form-control" id="editRole{{ $user->id_user }}" name="id_role" required>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id_role }}" {{ $role->id_role == $user->id_role ? 'selected' : '' }}>{{ $role->nama_role }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="editNama{{ $user->id_user }}">Nama</label>
                                            <input type="text" class="form-control" id="editNama{{ $user->id_user }}" name="nama" value="{{ $user->profile->nama ?? '' }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="editAlamat{{ $user->id_user }}">Alamat</label>
                                            <textarea class="form-control" id="editAlamat{{ $user->id_user }}" name="alamat" required>{{ $user->profile->alamat ?? '' }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="editNoTelp{{ $user->id_user }}">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="editNoTelp{{ $user->id_user }}" name="no_telp" value="{{ $user->profile->no_telp ?? '' }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Delete User Modal -->
                    <div class="modal fade" id="deleteUserModal{{ $user->id_user }}" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel{{ $user->id_user }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteUserModalLabel{{ $user->id_user }}">Delete User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this user?</p>
                                    <!-- Delete User Form -->
                                    <form action="{{ route('users.destroy', $user->id_user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- Create User Modal -->
        <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Create User Form -->
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="createUserID">User ID</label>
                                <input type="text" class="form-control" id="createUserID" name="user_id" required>
                            </div>
                            <div class="form-group">
                                <label for="createPassword">Password</label>
                                <input type="password" class="form-control" id="createPassword" name="password" required>
                            </div>
                            <div class="form-group">
                                <label for="createRole">Role</label>
                                <select class="form-control" id="createRole" name="id_role" required>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id_role }}">{{ $role->nama_role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="createNama">Nama</label>
                                <input type="text" class="form-control" id="createNama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="createAlamat">Alamat</label>
                                <textarea class="form-control" id="createAlamat" name="alamat" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="createNoTelp">Nomor Telepon</label>
                                <input type="text" class="form-control" id="createNoTelp" name="no_telp" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
