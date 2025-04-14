@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Create Role</h6>
                    <a href="{{ route('roles.index') }}" class="btn btn-primary">Back</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name">Role Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="permissions">Assign Permissions</label>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="form-check-input">
                                            <label class="form-check-label">{{ $permission->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
