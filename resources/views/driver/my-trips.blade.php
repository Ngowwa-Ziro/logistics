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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pickup Location</th>
                            <th>Dropoff Location</th>
                            <th>Product Type</th>
                            <th>Vehicle ID</th>
                            <th>Weight (kg)</th>
                            <th>Payment Status</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trips as $trip)
                        <tr>
                            <td>{{ $trip->id }}</td>
                            <td>{{ $trip->pickup_location }}</td>
                            <td>{{ $trip->dropoff_location }}</td>
                            <td>{{ $trip->product_type }}</td>
                            <td>{{ $trip->vehicle_id }}</td>
                            <td>{{ $trip->weight }} kg</td>
                            <td>
                                @if($trip->payment)
                                    @if($trip->payment->status == 'paid')
                                        <span class="badge badge-success">Paid</span>
                                    @elseif($trip->payment->status == 'unpaid')
                                        <span class="badge badge-warning">Unpaid</span>
                                    @elseif($trip->payment->status == 'failed')
                                        <span class="badge badge-danger">Failed</span>
                                    @endif
                                @else
                                    <span class="badge badge-secondary">No Payment</span>
                                @endif
                            </td>
                            <td>{{ ucfirst($trip->status) }}</td>
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
