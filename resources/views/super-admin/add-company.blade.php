@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Create Corporate Company</h6>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('super-admin.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name">Company Name</label>
                            <input type="text" name="name" class="form-control" placeholder="company name" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_person">Contact Person</label>
                            <input type="text" name="contact_person" class="form-control" placeholder="contact person" required>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="phone number" required>
                        </div>

                        <div class="mb-3">
                            <label for="address">Physical Address</label>
                            <textarea name="address" class="form-control" rows="3" placeholder="physical address" required></textarea>
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
