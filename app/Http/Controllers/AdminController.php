<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Trip;
use App\Models\User;
use App\Models\Payment;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $totalCustomersQuery = User::where('role', 'customer');
        $totalDriversQuery = User::where('role', 'driver');
        $totalVehiclesQuery = Vehicle::query();
        $totalTripsQuery = Trip::query();

        $totalPendingTripsQuery = Trip::where('status', 'pending');
        $totalCompletedTripsQuery = Trip::where('status', 'delivered');
        $totalCancelledTripsQuery = Trip::where('status', 'cancelled');

        $paidTripsQuery = Trip::whereHas('payments', function ($query) {
            $query->where('status', 'paid');
        });

        $unpaidTripsQuery = Trip::whereHas('payments', function ($query) {
            $query->where('status', 'unpaid');
        });

        $totalEarningsQuery = Trip::where('status', 'paid');
        $driversEarningsQuery = User::where('role', 'driver')
            ->withSum(['trips as total_earnings' => function ($query) {
                $query->where('status', 'paid');
            }], 'price');

        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $startDate = null;

            switch ($filter) {
                case 'today':
                    $startDate = Carbon::today();
                    break;
                case 'last7days':
                    $startDate = Carbon::now()->subDays(7);
                    break;
                case 'thismonth':
                    $startDate = Carbon::now()->startOfMonth();
                    break;
            }

            if ($startDate) {
                // Apply date filter to all queries
                $totalCustomersQuery = $totalCustomersQuery->where('created_at', '>=', $startDate);
                $totalDriversQuery = $totalDriversQuery->where('created_at', '>=', $startDate);
                $totalVehiclesQuery = $totalVehiclesQuery->where('created_at', '>=', $startDate);
                $totalTripsQuery = $totalTripsQuery->where('created_at', '>=', $startDate);
                $totalPendingTripsQuery = $totalPendingTripsQuery->where('created_at', '>=', $startDate);
                $totalCompletedTripsQuery = $totalCompletedTripsQuery->where('created_at', '>=', $startDate);
                $totalCancelledTripsQuery = $totalCancelledTripsQuery->where('created_at', '>=', $startDate);
                $paidTripsQuery = $paidTripsQuery->where('created_at', '>=', $startDate);
                $unpaidTripsQuery = $unpaidTripsQuery->where('created_at', '>=', $startDate);
                $totalEarningsQuery = $totalEarningsQuery->where('created_at', '>=', $startDate);
                $driversEarningsQuery = $driversEarningsQuery->whereHas('trips', function ($query) use ($startDate) {
                    $query->where('created_at', '>=', $startDate);
                });
            }
        }

        // Now get the counts and sums after applying the filters
        $totalCustomers = $totalCustomersQuery->count();
        $totalDrivers = $totalDriversQuery->count();
        $totalVehicles = $totalVehiclesQuery->count();
        $totalTrips = $totalTripsQuery->count();

        $totalPendingTrips = $totalPendingTripsQuery->count();
        $totalCompletedTrips = $totalCompletedTripsQuery->count();
        $totalCancelledTrips = $totalCancelledTripsQuery->count();

        $paidTrips = $paidTripsQuery->count();
        $unpaidTrips = $unpaidTripsQuery->count();

        $totalEarnings = $totalEarningsQuery->sum('price');
        $driversEarnings = $driversEarningsQuery->get(['id', 'name']);

        return view('admin.dashboard', compact(
            'totalCustomers', 'totalTrips', 'totalDrivers', 'totalVehicles',
            'totalPendingTrips', 'totalCompletedTrips', 'totalCancelledTrips',
            'totalEarnings', 'driversEarnings', 'paidTrips', 'unpaidTrips'
        ));
    }


    public function manageTrips()
    {
        $trip = DB::table('trips')-> where('status', 'approved')->paginate(10);
        $drivers = DB::table('users')->where('role', 'driver')->paginate(10);

        return view('admin.manage-trips', compact('trip', 'drivers'));
    }

    public function assignDriver(Request $request, $id)
    {
        //dd($request);
        $request->validate([
            'weight' => 'required|numeric|min:1',
            'driver_id' => 'required|exists:users,id',
        ]);

        //dd($request->all());

        $booking = Trip::findOrFail($id);

        $weight = $request->input('weight');
        $price = $this->calculatePrice($weight);

        $booking->update(attributes: [
            'weight' => $weight,
            'driver_id' => $request->input('driver_id'),
            'price' => $price,
            'status' => 'confirmed'
        ]);

        return redirect()->route('admin.allTrips')->with('success', 'Driver assigned and trips updated successfully!');
    }

    private function calculatePrice($weight)
    {
        if ($weight <= 5) {
            return 1000;
        } elseif ($weight <= 10) {
            return 1500;
        } elseif ($weight <= 15) {
            return 2000;
        } elseif ($weight <= 25) {
            return 3000;
        }
        return 3000;
    }

    public function allTrips()
    {
        $trips = Trip::with('payments')->paginate(10);

        return view('admin.all-trips', compact('trips'));
    }


    public function driverIncomeReport(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $driverIncomes = DB::table('payments')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return view('reports.driver-report', compact('driverIncomes', 'startDate', 'endDate'));
    }


    public function vehicle()
    {
        $vehicleTypes = ['Bike', 'Van', 'Truck'];

        return view('admin.add-vehicle', compact('vehicleTypes'));
    }

    public function addVehicle(Request $request)
    {
      //  dd($request->all());

        $request->validate([
            'vehicle_type' => 'required|string',
            'model' => 'required|string',
            'number_plate' => 'required|string|unique:vehicles',
        ]);


        $vehicle = new Vehicle();
        $vehicle->vehicle_type = $request->vehicle_type;
        $vehicle->model = $request->model;
        $vehicle->number_plate = $request->number_plate;
        //dd($vehicle);
        $vehicle->save();

        return redirect()->route('vehicles.all')->with('success', 'Vehicle added successfully');
    }


    public function viewVehicles()
    {
        $vehicles = Vehicle::paginate(10);

        return view('admin.all-vehicles', compact('vehicles'));
    }





}
