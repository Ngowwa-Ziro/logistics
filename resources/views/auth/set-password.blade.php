@extends('layouts.authlayout')

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
                    <form action="{{ route('set-password.submit', $id) }}" method="POST">
                        @csrf
                        {{-- <input type="hidden" name="token" value="{{ request('token') }}"> --}}

                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Confirm Password</label>
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
