@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Unsuccessful Trips</h6>
                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if(isset($unsuccessfulTrips) && count($unsuccessfulTrips) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="unsuccessfulTripsTable">
                                <thead>
                                    <tr>
                                        <th>Trip ID</th>
                                        <th>Pickup Location</th>
                                        <th>Dropoff Location</th>
                                        <th>Product Type</th>
                                        <th>Weight (kg)</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Driver</th>
                                        <th>Vehicle ID</th>
                                        <th>Trip Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($unsuccessfulTrips as $trip)
                                        <tr>
                                            <td>{{ $trip->id }}</td>
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
                                            <td>{{ $trip->created_at->format('Y-m-d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="pagination mt-3">
                            {{ $unsuccessfulTrips->links('pagination::bootstrap-5') }}
                        </div>

                    @else
                        <p class="mt-4">No records found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
