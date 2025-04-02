{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <h2>Book a Trip</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('trips.book') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Pickup Location</label>
            <input type="text" name="pickup_location" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Dropoff Location</label>
            <input type="text" name="dropoff_location" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Product Type</label>
            <input type="text" name="product_type" class="form-control" required>
        </div>

        @guest
        <div class="mb-3">
            <label class="form-label">Your Name (Optional)</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Number (Optional)</label>
            <input type="text" name="phone" class="form-control">
        </div>
        @endguest

        <button type="submit" class="btn btn-primary">Book Trip</button>
    </form>

</div>
@endsection --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Book a Trip</div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('trips.book') }}" method="POST">
                        @csrf

                        <!-- Pickup Location -->
                        <div class="form-group mb-3">
                            <label for="pickup_location">Pickup Location:</label>
                            <input type="text" name="pickup_location" id="pickup_location" class="form-control" required>
                        </div>

                        <!-- Dropoff Location -->
                        <div class="form-group mb-3">
                            <label for="dropoff_location">Dropoff Location:</label>
                            <input type="text" name="dropoff_location" id="dropoff_location" class="form-control" required>
                        </div>

                        <!-- Product Type -->
                        <div class="form-group mb-3">
                            <label for="product_type">Product Type:</label>
                            <select name="product_type" id="product_type" class="form-control" required>
                                <option value="Standard">Standard</option>
                                <option value="Luxury">Luxury</option>
                                <option value="Cargo">Cargo</option>
                            </select>
                        </div>

                        @guest
                        <!-- Guest User: Name -->
                        <div class="form-group mb-3">
                            <label for="name">Your Name:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <!-- Guest User: Phone -->
                        <div class="form-group mb-3">
                            <label for="phone">Phone Number:</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>
                        @endguest

                        <button type="submit" class="btn btn-primary">Book Trip</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

