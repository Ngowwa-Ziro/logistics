@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">My Assigned Trips</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Pickup Location</th>
                            <th>Dropoff Location</th>
                            <th>Product Type</th>
                            <th>Weight (kg)</th>
                            <th>Fare</th>
                            <th>Status</th>
                            <th>Vehicle ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trips as $trip)
                            <tr>
                                <td>{{ $trip->pickup_location }}</td>
                                <td>{{ $trip->dropoff_location }}</td>
                                <td>{{ $trip->product_type }}</td>
                                <td>{{ $trip->weight }} kg</td>
                                <td>Ksh {{ number_format($trip->fare, 2) }}</td>
                                <td>{{ ucfirst($trip->status) }}</td>
                                <td>{{ $trip->vehicle_id }}</td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        @if($trip->status == 'confirmed')
                                            <a href="{{ route('startTrip', $trip->id) }}" class="btn btn-primary btn-sm mr-2">Start</a>
                                        @elseif($trip->status == 'transit')
                                            <a href="{{ route('completeTrip', $trip->id) }}" class="btn btn-success btn-sm mr-2">Complete</a>
                                        @endif

                                        @if($trip->status != 'delivered' && $trip->status != 'cancelled')
                                            <a href="{{ route('cancelTrip', $trip->id) }}" class="btn btn-danger btn-sm">Cancel</a>
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $trips->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
