@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Daftar Role</h1>

        @if (Cookie::get('nama_role') === 'Admin')
            <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createRoleModal">
                Create Role
            </button>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Role</th>
                    @if (Cookie::get('nama_role') === 'Admin')
                    <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->id_role }}</td>
                        <td>{{ $role->nama_role }}</td>
                        @if (Cookie::get('nama_role') === 'Admin')
                        <td>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editRoleModal{{ $role->id_role }}">
                                Edit
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteRoleModal{{ $role->id_role }}">
                                Delete
                            </button>
                        </td>
                        @endif
                    </tr>
                    <!-- Edit Role Modal -->
                    <div class="modal fade" id="editRoleModal{{ $role->id_role }}" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLabel{{ $role->id_role }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editRoleModalLabel{{ $role->id_role }}">Edit Role</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Edit Role Form -->
                                    <form action="{{ route('roles.update', $role->id_role) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="editNamaRole{{ $role->id_role }}">Nama Role</label>
                                            <input type="text" class="form-control" id="editNamaRole{{ $role->id_role }}" name="nama_role" value="{{ $role->nama_role }}" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Delete Role Modal -->
                    <div class="modal fade" id="deleteRoleModal{{ $role->id_role }}" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel{{ $role->id_role }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteRoleModalLabel{{ $role->id_role }}">Delete Role</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this role?</p>
                                    <!-- Delete Role Form -->
                                    <form action="{{ route('roles.destroy', $role->id_role) }}" method="POST">
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

        <!-- Create Role Modal -->
        <div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createRoleModalLabel">Create Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Create Role Form -->
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="createNamaRole">Nama Role</label>
                                <input type="text" class="form-control" id="createNamaRole" name="nama_role" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
