@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Manage Pending Trips</h6>
                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if(isset($trip) && count($trip) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="pendingTripsTable">
                                <thead>
                                    <tr>
                                        <th>Pickup Location</th>
                                        <th>Dropoff Location</th>
                                        <th>Product Type</th>
                                        <th>Status</th>
                                        <th>Vehicle ID</th>
                                        <th>Weight (kg)</th>
                                        <th>Assign Driver</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trip as $singletrip)
                                        <tr>
                                            <form action="{{ route('trips.assignDriver', ['id' => $singletrip->id]) }}" method="POST">
                                                @csrf
                                                <td>{{ $singletrip->pickup_location }}</td>
                                                <td>{{ $singletrip->dropoff_location }}</td>
                                                <td>{{ $singletrip->product_type }}</td>
                                                <td>{{ ucfirst($singletrip->status) }}</td>
                                                <td>{{ $singletrip->vehicle_id }}</td>
                                                <td>
                                                    <input type="number" name="weight" class="form-control" placeholder="Enter weight">
                                                </td>
                                                <td>
                                                    <select name="driver_id" class="form-control">
                                                        <option value="">Select Driver</option>
                                                        @foreach($drivers as $driver)
                                                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td>
                                                    <button type="submit" class="btn btn-primary">Assign</button>
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-center">
                                {{ $trip->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @else
                        <p class="mt-4">No pending trips found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
