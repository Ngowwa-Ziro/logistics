<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Payment;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $customerId = Auth::id();

        $trips = Trip::where('customer_id', $customerId)->get();
        $payments = Payment::where('customer_id', $customerId)->get();

        return view('customer.dashboard', compact('trips', 'payments'));
    }


    public function viewTrips()
    {
        $customerTrips = Trip::where('customer_id', auth()->id())
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view('customer.trips', compact('customerTrips'));
    }


    public function Trip()
    {
        $productTypes = ['Envelope', 'Box', 'Pallet'];
        $vehicleTypes = ['Bike', 'Van', 'Truck'];

        return view('customer.book', compact('productTypes', 'vehicleTypes'));
    }

    public function bookTrip(Request $request)
    {
        $request->validate([
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
            'product_type' => 'required|string',
            'vehicle_type' => 'required|string|in:Bike,Van,Truck', 
            'booking_type' => 'required|string',
            'time' => $request->booking_type == 'later' ? 'required|date' : 'nullable',
        ]);

        // Get the first available vehicle matching the selected type
        $vehicle = Vehicle::where('vehicle_type', $request->vehicle_type)->first();

        if (!$vehicle) {
            return redirect()->back()->with('error', 'No available vehicle for the selected type.');
        }

        // Handle time for "Book Now" scenario
        $time = $request->booking_type === 'later' ? $request->time : now();

        $trip = Trip::create([
            'customer_id' => Auth::id(),
            'pickup_location' => $request->pickup_location,
            'dropoff_location' => $request->dropoff_location,
            'product_type' => $request->product_type,
            'vehicle_id' => $vehicle->id,
            'time' => $time,
            'status' => 'pending',
        ]);

        return redirect()->route('view.trip')->with('success', 'Trip booked successfully!');
    }


    public function approveTrip(Trip $trip)
    {
        if ($trip->status !== 'pending') {
            return redirect()->back()->with('error', 'Trip cannot be approved.');
        }

        $trip->status = 'approved';
        $trip->save();

        return redirect()->back()->with('success', 'Trip approved successfully.');
    }

    public function cancelTrip(Trip $trip)
    {
        if ($trip->status == 'delivered') {
            return redirect()->back()->with('error', 'completed trips cannot be cancelled.');
        }

        $trip->status = 'cancelled';
        $trip->save();

        return redirect()->back()->with('success', 'Trip cancelled successfully.');
    }


    // public function pay()
    // {
    //     return view('customer.payment');
    // }

    public function makePayment($tripId)
    {
        $customerId = Auth::id();

        $trip = Trip::where('id', $tripId)
                    ->where('customer_id', $customerId)
                    ->first();


        if ($trip && $trip->status == 'delivered') {
            return view('customer.payment', compact('trip'));
        } else {
            return redirect()->route('customer.dashboard')->with('error', 'This trip is not completed. Payment cannot be made.');
        }
    }


    public function storePayment(Request $request, $tripId)
    {
        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string|max:255',
        ]);

        $customerId = Auth::id();

        $trip = Trip::where('id', $tripId)
                    ->where('customer_id', $customerId)
                    ->first();


        if ($trip && $trip->status == 'completed') {
            Payment::create([
                'customer_id' => $customerId,
                'trip_id' => $tripId,
                'amount' => $validatedData['amount'],
                'payment_method' => $validatedData['payment_method'],
                'status' => 'pending',
            ]);

            $trip->status = 'paid';
            $trip->save();

            return redirect()->route('customer.dashboard')->with('success', 'Payment made successfully.');
        } else {
            return redirect()->route('customer.dashboard')->with('error', 'This trip is not completed. Payment cannot be made.');
        }
    }

    // public function index()
    // {
    //     $trip = DB::table('trips')-> where('status', 'completed') -> get();

    //     return view('customer.my-trips', compact('trip'));
    // }


}
