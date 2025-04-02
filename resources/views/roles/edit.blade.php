@extends('layouts.app')

@section("content")

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4>Edit Role
                        <a href="{{ route('roles.index') }}" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name">Role Name</label>
                            <input type="text" id="name" value="{{ $role->name }}" name="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="permissions">Assign Permissions</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="permission{{ $permission->id }}" class="form-check-input"
                                                {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                            <label for="permission{{ $permission->id }}" class="form-check-label">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
