@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Company</h6>
                    <a href="{{ route('corporates.index') }}" class="btn btn-primary float-end">Back</a>
                </div>
                <div class="card-body">

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('corporates.update', $company->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name">Company Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $company->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="contact_person">Contact Person</label>
                            <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $company->contact_person) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $company->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $company->phone) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-control" value="{{ old('address', $company->address) }}" required>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-success">Update Company</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
