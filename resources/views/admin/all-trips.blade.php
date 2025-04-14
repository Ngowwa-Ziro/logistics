@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Trips</h6>
                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if(isset($trips) && count($trips) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tripsTable">
                                <thead>
                                    <tr>
                                        <th>Trip ID</th>
                                        <th>Pickup Location</th>
                                        <th>Dropoff Location</th>
                                        <th>Product Type</th>
                                        <th>Vehicle ID</th>
                                        <th>Weight (kg)</th>
                                        <th>Price (Ksh)</th>
                                        <th>Price Status</th>
                                        <th>Driver</th>
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
                                            <td>{{ $trip->weight }}</td>
                                            <td>{{ number_format($trip->price, 2) }}</td>
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
                                            <td>{{ $trip->driver->name ?? 'N/A' }}</td>
                                            <td>{{ ucfirst($trip->status) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination mt-3">
                            {{ $trips->links('pagination::bootstrap-5') }}
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
