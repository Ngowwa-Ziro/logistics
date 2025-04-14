<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function create()
    {
        return view('trips.book');

    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup_location' => 'required|string|max:255',
            'dropoff_location' => 'required|string|max:255',
            'product_type' => 'required|string|max:255',
            'weight' => 'required|numeric|min:1', // Validating weight input
        ]);

        try {
            if (auth()->check()) {
                // If the user is logged in, use their ID
                $customerId = auth()->id();
            } else {
                // Check if a user with the same phone number exists
                $customer = User::where('phone', $request->phone)->first();

                if (!$customer) {
                    // Create a temporary customer record for guests
                    $customer = User::create([
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'password' => bcrypt(Str::random(10)), // Assign a random password
                    ]);
                }

                $customerId = $customer->id;
            }

            // Calculate price based on weight and product type
            $price = $this->calculatePrice($request->weight, $request->product_type);

            // Create the trip
            $trip = Trip::create([
                'customer_id' => $customerId,
                'pickup_location' => $request->pickup_location,
                'dropoff_location' => $request->dropoff_location,
                'product_type' => $request->product_type,
                'weight' => $request->weight,  // Store weight
                'price' => $price,  // Store the calculated price
                'status' => 'pending',
            ]);

            return redirect()->route('trips.index')->with('success', 'Trip booked successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    private function calculatePrice($weight, $productType)
    {
        // Define pricing tiers based on weight and product type
        $basePrice = 100; // Default price

        switch ($productType) {
            case 'Standard':
                $pricePerKg = 10;
                break;
            case 'Luxury':
                $pricePerKg = 20;
                break;
            case 'Cargo':
                $pricePerKg = 30;
                break;
            default:
                $pricePerKg = 10;
                break;
        }

        // Calculate price: base price + price based on weight
        return $basePrice + ($weight * $pricePerKg);
    }



    public function cancel($id)
    {
        $trip = Trip::findOrFail($id);

        if (Auth::id() == $trip->customer_id || Auth::id() == $trip->driver_id) {
            $trip->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Trip cancelled.');
        }

        return redirect()->back()->with('error', 'Unauthorized.');
    }

    public function approve($id)
    {
        $trip = Trip::findOrFail($id);

        $trip->update([
            'status' => 'transit',
            'driver_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Trip approved.');
    }



    public function index()
    {
        $trips = Trip::all();
        return view('trips.index', compact('trips'));
    }
}
