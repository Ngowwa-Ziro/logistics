@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container mt-4">
    <h2>My Profile
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to dashboard
        </a>
    </h2>
    <p class="text-muted">View and update your profile details.</p>

    <div class="card shadow-sm p-3">
        <div class="card-body">
            <h4 class="mb-3">User Information</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="username">Username</label>
                    <input type="text" id="username" class="form-control" value="" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" class="form-control" value="" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" class="form-control" value="" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" class="form-control" value="" readonly>
                </div>
            </div>

            <h4 class="mb-3">Contact Information</h4>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="address">Address</label>
                    <input type="text" id="address" class="form-control" value="" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="city">City</label>
                    <input type="text" id="city" class="form-control" value="" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="country">Country</label>
                    <input type="text" id="country" class="form-control" value="" readonly>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="postal_code">Postal Code</label>
                    <input type="text" id="postal_code" class="form-control" value="" readonly>
                </div>
            </div>

            <h4 class="mb-3">OTP Delivery Channel</h4>
            <div class="row">
                <div class="col-md-12 mb-3 d-flex align-items-center justify-content-start" style="gap: 50px;">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="otp_email">
                        <label class="form-check-label" for="otp_email">Email</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="otp_sms">
                        <label class="form-check-label" for="otp_sms">SMS</label>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary">Save</button>
        </div>
    </div>
</div>
@endsection
