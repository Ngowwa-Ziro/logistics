@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Add Vehicle</h6>
        </div>
        <div class="card-body">
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('vehicles.store') }}">
                @csrf

                <div class="form-group">
                    <label for="vehicle_type">Vehicle Type</label>
                    <select class="form-control" name="vehicle_type" required>
                        @foreach($vehicleTypes as $vehicleType)
                            <option value="{{ $vehicleType }}">{{ $vehicleType }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" class="form-control" name="model" required>
                </div>

                <div class="form-group">
                    <label for="number_plate">Number Plate</label>
                    <input type="text" class="form-control" name="number_plate" required>
                </div>

                <button type="submit" class="btn btn-primary">Add Vehicle</button>
            </form>
        </div>
    </div>
</div>
@endsection
