@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Vehicles</h6>
                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if(isset($vehicles) && count($vehicles) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered" id="vehiclesTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vehicle Type</th>
                                        <th>Model</th>
                                        <th>Number Plate</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vehicles as $key => $vehicle)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $vehicle->vehicle_type }}</td>
                                            <td>{{ $vehicle->model }}</td>
                                            <td>{{ $vehicle->number_plate }}</td>
                                            <td>{{ $vehicle->created_at->format('d M Y, H:i A') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="pagination mt-3">
                            {{ $vehicles->links('pagination::bootstrap-5') }}
                        </div>
                    @else
                        <p class="mt-4">No vehicles found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
