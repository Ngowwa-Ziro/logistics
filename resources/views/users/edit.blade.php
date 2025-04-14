@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Edit User </h6>
                    <a href="{{ route('users.index')}}" class="btn btn-primary float-end">Back</a>

                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone">Phone Number</label>
                            <input type="number" name="phone" value="{{ $user->phone }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="roles">Roles</label>
                            <select name="roles[]" class="form-control">
                                <option value="">Select Role</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ in_array($role, $userRoles) ? 'selected':''}}>{{ $role }}</option>
                                @endforeach
                            </select>

                            @error('roles')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
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
