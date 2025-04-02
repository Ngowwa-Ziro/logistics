@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header">Set Your Password</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('setPassword') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ request('email') }}">

                        <div class="mb-3">
                            <label for="password">New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Set Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
