@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Manage Permissions for Role: <strong>{{ $role->name }}</strong></h6>
                    <a href="{{ route('roles.index') }}" class="btn btn-primary">Back</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

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
                                            <input type="checkbox" class="form-check-input" name="permissions[]" value="{{ $permission->name }}" {{ in_array($permission->id, array_keys($rolePermissions)) ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $permission->name }}</label>
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
