@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Trips List</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Pickup Location</th>
                <th>Dropoff Location</th>
                <th>Product Type</th>
                <th>Status</th>
                <th>Driver</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trips as $trip)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $trip->pickup_location }}</td>
                    <td>{{ $trip->dropoff_location }}</td>
                    <td>{{ $trip->product_type }}</td>
                    <td>
                        <span class="badge
                            @if ($trip->status == 'pending') badge-warning
                            @elseif ($trip->status == 'approved') badge-success
                            @elseif ($trip->status == 'cancelled') badge-danger
                            @endif">
                            {{ ucfirst($trip->status) }}
                        </span>
                    </td>
                    <td>
                        @if($trip->driver)
                            {{ $trip->driver->name }}
                        @else
                            <span class="text-muted">Not Assigned</span>
                        @endif
                    </td>
                    <td>
                        @if ($trip->status == 'pending')

                                <form action="{{ route('trips.approve', $trip->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                </form>

                                <form action="{{ route('trips.cancel', $trip->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                </form>

                        @else
                            <span class="text-muted">No Actions</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
