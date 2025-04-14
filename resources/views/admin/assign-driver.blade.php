@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Manage Trip</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.storeDriverAssignment', $trip->id) }}">
        @csrf
        <div class="form-group">
            <label for="pickup_location">Pickup Location</label>
            <input type="text" class="form-control" name="pickup_location" value="{{ $trip->pickup_location }}" readonly>
        </div>

        <div class="form-group">
            <label for="dropoff_location">Dropoff Location</label>
            <input type="text" class="form-control" name="dropoff_location" value="{{ $trip->dropoff_location }}" readonly>
        </div>

        <div class="form-group">
            <label for="product_type">Product Type</label>
            <input type="text" class="form-control" name="product_type" value="{{ $trip->product_type }}" readonly>
        </div>

        <div class="form-group">
            <label for="vehicle">Vehicle</label>
            <input type="text" class="form-control" name="vehicle" value="{{ $trip->vehicle }}" readonly>
        </div>

        <div class="form-group">
            <label for="weight">Weight (kg)</label>
            <input type="number" class="form-control" name="weight" id="weight" value="{{ old('weight') }}" required>
        </div>

        <div class="form-group">
            <label for="price">Price (Calculated based on weight)</label>
            <input type="text" class="form-control" name="price" id="price" value="{{ old('price') }}" readonly>
        </div>

        <div class="form-group">
            <label for="driver_id">Assign Driver</label>
            <select class="form-control" name="driver_id" required>
                @foreach($drivers as $driver)
                    <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                        {{ $driver->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Assign Driver</button>
    </form>
</div>

<script>
    document.getElementById('weight').addEventListener('input', function () {
        var weight = this.value;
        var price = 0;

        if (weight <= 5) {
            price = 1000;
        } else if (weight <= 10) {
            price = 1500;
        } else if (weight <= 15) {
            price = 2000;
        } else {
            price = 2500; // Default price for higher weights
        }

        document.getElementById('price').value = price;
    });
</script>
@endsection
