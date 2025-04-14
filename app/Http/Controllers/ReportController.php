<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function successfulTrips(Request $request)
    {

        $successfulTrips = Trip::where('status', 'delivered')
                                ->paginate(10);

        return view('reports.successful', compact('successfulTrips',));
    }

    public function unsuccessfulTrips(Request $request)
    {
        // $startDate = $request->start_date;
        // $endDate = $request->end_date;

        // dd($startDate, $endDate);


        $unsuccessfulTrips = Trip::whereIn('status', ['pending', 'transit', 'cancelled'])
                                    ->paginate(10);


        //dd( $unsuccessfulTrips);

        return view('reports.unsuccessful', compact('unsuccessfulTrips',));
    }


    public function driverIncomeReport(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Fetch all trips that fall within the date range
        $trips = Trip::whereBetween('created_at', [$startDate, $endDate])
                       ->paginate(10);

        // Fetch payments corresponding to the trips
        $payments = Payment::whereBetween('created_at', [$startDate, $endDate])
                            ->paginate(10);

        // Prepare data for the report
        $driverIncomes = [];
        foreach ($trips as $trip) {
            // Get the payment for each trip
            $payment = $payments->where('trip_id', $trip->id)->first();

            if ($payment) {
                $driverIncomes[] = [
                    'driver_id' => $trip->driver_id,
                    'trip_id' => $trip->id,
                    'pickup_location' => $trip->pickup_location,
                    'dropoff_location' => $trip->dropoff_location,
                    'product_type' => $trip->product_type,
                    'status' => ucfirst($trip->status),
                    'vehicle' => $trip->vehicle,
                    'weight' => $trip->weight,
                    'payment_amount' => $payment->amount,
                    'payment_method' => $payment->payment_method,
                    'payment_time' => $payment->created_at->format('Y-m-d H:i'),
                ];
            }
        }


        return view('reports.driver-report', compact('driverIncomes', 'startDate', 'endDate'));
    }
}
