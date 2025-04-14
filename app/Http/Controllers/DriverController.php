<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function dashboard()
    {
        $driverId = Auth::id();

        $assignedTrips = Trip::where('driver_id', $driverId)
                            ->whereIn('status', ['confirmed'])
                            ->get();

        $completedTrips = Trip::where('driver_id', $driverId)
                            ->where('status', 'delivered')
                            ->whereNotNull('updated_at')
                            ->get();


        $cancelledTrips = Trip::where('driver_id', $driverId)
                            ->where('status', 'cancelled')
                            ->get();

        return view('driver.dashboard', compact('assignedTrips', 'completedTrips', 'cancelledTrips'));
    }

    public function viewTrips()
    {
        $trips = Trip::where('driver_id', auth()->id())
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);


        return view('driver.trips', compact('trips'));
    }

    public function startTrip($tripId)
    {
        $trip = Trip::findOrFail($tripId);

        if ($trip->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Trip cannot be started.');
        }

        $trip->status = 'transit';
        $trip->save();

        return redirect()->route('viewTrip')->with('success', 'Trip started.');
    }

    public function completeTrip($id)
    {
        $trip = Trip::findOrFail($id);

        if ($trip->status !== 'transit') {
            return redirect()->back()->with('error', 'Trip cannot be completed.');
        }

        $trip->status = 'delivered';
        $trip->save();

        return redirect()->route('index')->with('success', 'Trip completed successfully.');
    }

    public function cancelTrip($id)
    {
        $trip = Trip::findOrFail($id);

        if ($trip->status === 'delivered') {
            return redirect()->back()->with('error', 'Completed trip cannot be cancelled.');
        }

        $trip->status = 'cancelled';
        $trip->save();

        return redirect()->route('index')->with('success', 'Trip cancelled successfully.');
    }

    public function index()
    {
        $driverId = auth()->user()->id;

        $trips = Trip::where('driver_id', $driverId)
                    ->with('payments')
                    ->paginate(10);

        return view('driver.my-trips', compact('trips'));
    }
}






