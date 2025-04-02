@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="container mt-4">
    <h2>Edit Profile</h2>
    <p class="text-muted">Update your profile details.</p>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
        <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
