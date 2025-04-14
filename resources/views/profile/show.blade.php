@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="container mt-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">My Profile</h6>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
               Back to Dashboard
            </a>
        </div>
        <div class="card-body">

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <h4 class="mb-3">User Information</h4>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Username</label>
                    <input type="text" class="form-control" value="{{ $user->username }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Email Address</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" readonly>
                </div>
            </div>

            <h4 class="mb-3">Contact Information</h4>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label>Address</label>
                    <input type="text" class="form-control" value="{{ $user->address }}" readonly>
                </div>
            </div>

            <h4 class="mb-3">OTP Delivery Channel</h4>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="otp_email" checked>
                        <label class="form-check-label">Email</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
