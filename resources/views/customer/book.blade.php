@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Book a Trip</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('customer.bookTrip') }}">
                @csrf

                <div class="form-group">
                    <label for="pickup_location">Pick-up Location</label>
                    <input type="text" class="form-control" name="pickup_location" placeholder="Pick-up" required>
                </div>

                <div class="form-group">
                    <label for="dropoff_location">Drop-off Location</label>
                    <input type="text" class="form-control" name="dropoff_location" placeholder="Drop-off" required>
                </div>

                <div class="form-group">
                    <label for="product_type">Product Type</label>
                    <select class="form-control" name="product_type" placeholder="Enter email" required>
                        @foreach($productTypes as $product)
                        <option value="{{ $product }}">{{ $product }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="vehicle_type">Vehicle Type</label>
                    <select class="form-control" name="vehicle_type" placeholder="Vehicle Type" required>
                        @foreach($vehicleTypes as $vehicleType)
                            <option value="{{ $vehicleType }}">{{ $vehicleType }}</option>
                        @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label for="booking_type">Booking Type</label><br>
                    <input type="radio" id="book_now" name="booking_type" value="now" required>
                    <label for="book_now">Book Now</label><br>
                    <input type="radio" id="schedule_later" name="booking_type" value="later" required>
                    <label for="schedule_later">Schedule for Later</label>
                </div>

                <div id="datetime-container" class="form-group" style="display: none;">
                    <label for="time">Date and Time</label>
                    <input type="datetime-local" class="form-control" name="time">
                </div>


                <button type="submit" class="btn btn-primary">Book Trip</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('input[name="booking_type"]').forEach((elem) => {
        elem.addEventListener('change', function() {
            if (document.getElementById('schedule_later').checked) {
                document.getElementById('datetime-container').style.display = 'block';
            } else {
                document.getElementById('datetime-container').style.display = 'none';
            }
        });
    });
</script>

@endsection
