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
                    <h4>Manage Permissions for Role: <strong>{{ $role->name }}</strong>
                        <a href="{{ route('roles.index') }}" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.givePermissionToRole', $role->id) }}" method="POST">
                        @csrf
                        @method('POST')

                        <div class="mb-3">
                            @error('permissions')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <label>Permissions</label>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input type="checkbox"
                                                class="form-check-input"
                                                name="permissions[]"
                                                value="{{ $permission->name }}"
                                                {{ in_array($permission->id, array_keys($rolePermissions)) ? 'checked' : '' }}>

                                            <label class="form-check-label">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update Permissions</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
