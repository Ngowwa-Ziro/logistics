@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">My Trips</h6>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="myTripsTable">
                    <thead>
                        <tr>
                            <th>Pickup Location</th>
                            <th>Dropoff Location</th>
                            <th>Product Type</th>
                            <th>Weight (kg)</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Driver</th>
                            <th>Vehicle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customerTrips as $trip)
                            <tr>
                                <td>{{ $trip->pickup_location }}</td>
                                <td>{{ $trip->dropoff_location }}</td>
                                <td>{{ $trip->product_type }}</td>
                                <td>{{ $trip->weight }} kg</td>
                                <td>Ksh {{ number_format($trip->price, 2) }}</td>
                                <td>{{ ucfirst($trip->status) }}</td>
                                <td>
                                    @if($trip->driver)
                                        {{ $trip->driver->name }}
                                    @else
                                        Not Assigned
                                    @endif
                                </td>
                                <td>{{ $trip->vehicle_id }}</td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        @if($trip->status == 'pending')
                                            <a href="{{ route('customer.approveTrip', $trip->id) }}" class="btn btn-success btn-sm mr-2">Approve</a>
                                            <a href="{{ route('customer.cancelTrip', $trip->id) }}" class="btn btn-danger btn-sm mr-2">Cancel</a>
                                        @elseif($trip->status == 'approved')
                                            <span class="text-info">Waiting for Driver</span>
                                        @elseif($trip->status == 'transit')
                                            <span class="text-warning">In Transit</span>
                                        @elseif($trip->status == 'completed')
                                            <span class="text-success">Completed</span>
                                        @elseif($trip->status == 'cancelled')
                                            <span class="text-danger">Cancelled</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $customerTrips->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection





