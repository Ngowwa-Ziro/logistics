@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Driver Income Report</h6>
                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form method="GET" action="{{ route('admin.driverIncomeReport') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" value="{{ old('start_date', $startDate ?? '') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{ old('end_date', $endDate ?? '') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary mt-4">Generate Report</button>
                            </div>
                        </div>
                    </form>

                    @if(isset($driverIncomes) && count($driverIncomes) > 0)
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered" id="driverIncomeTable">
                                <thead>
                                    <tr>
                                        <th>Driver ID</th>
                                        <th>Pickup Location</th>
                                        <th>Dropoff Location</th>
                                        <th>Product Type</th>
                                        <th>Status</th>
                                        <th>Vehicle</th>
                                        <th>Weight</th>
                                        <th>Payment Amount</th>
                                        <th>Payment Method</th>
                                        <th>Payment Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($driverIncomes as $income)
                                        <tr>
                                            <td>{{ $income['driver_id'] }}</td>
                                            <td>{{ $income['pickup_location'] }}</td>
                                            <td>{{ $income['dropoff_location'] }}</td>
                                            <td>{{ $income['product_type'] }}</td>
                                            <td>{{ $income['status'] }}</td>
                                            <td>{{ $income['vehicle'] }}</td>
                                            <td>{{ $income['weight'] }} kg</td>
                                            <td>${{ number_format($income['payment_amount'], 2) }}</td>
                                            <td>{{ ucfirst($income['payment_method']) }}</td>
                                            <td>{{ $income['payment_time'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $driverIncomes->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    @else
                        <p class="mt-4">No records found for the selected date range.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
