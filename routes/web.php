<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SuperAdminCompanyController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




    Route::get('/', [AuthController::class, 'login'])->name('login');
    Route::post("/login", [AuthController::class, "loginPost"])->name("login.post");
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
    Route::get('/show-otp', [AuthController::class, 'showOtp'])->name('show.otp');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
    Route::get('/resend-otp', [AuthController::class, 'resendOtp'])->name('resend.otp');
    Route::get('set-password/{id}', [UserController::class, 'showSetPasswordForm'])->name('set-password.form');
    Route::post('set-password/{id}', [UserController::class, 'setPassword'])->name('set-password.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/set-password', [AuthController::class, 'showSetPasswordForm'])->name('setPasswordForm');
    Route::post('/set-password', [AuthController::class, 'setPassword'])->name('setPassword');




Route::middleware(['auth:web', 'user.status'])->group(function(){

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/trips', [AdminController::class, 'manageTrips'])->name('manageTrips');
        Route::get('/admin/trips/all', [AdminController::class, 'allTrips'])->name('admin.allTrips');
        Route::post('/admin/trips/assign-driver/{id}', [AdminController::class, 'assignDriver'])->name('trips.assignDriver');
        Route::get('admin/driver-income-report', [ReportController::class, 'driverIncomeReport'])->name('admin.driverIncomeReport');
        Route::get('admin/vehicles/create', [AdminController::class, 'vehicle'])->name('vehicles.create');
        Route::post('admin/vehicles', [AdminController::class, 'addVehicle'])->name('vehicles.store');
        Route::get('/admin/vehicles', [AdminController::class, 'viewVehicles'])->name('vehicles.all');


    });


    Route::middleware(['auth', 'role:driver'])->group(function () {
        Route::get('/driver/dashboard', [DriverController::class, 'dashboard'])->name('driver.dashboard');
        Route::get('/driver/trip/view', [DriverController::class, 'viewTrips'])->name('viewTrip');
        Route::get('/driver/trips', [DriverController::class, 'index'])->name('index');
        Route::get('/trip/start/{id}', [DriverController::class, 'startTrip'])->name('startTrip');
        Route::get('/trip/complete/{id}', [DriverController::class, 'completeTrip'])->name('completeTrip');
        Route::get('/trip/cancel/{id}', [DriverController::class, 'cancelTrip'])->name('cancelTrip');
    });


    Route::middleware(['auth', 'role:customer'])->group(function () {
        Route::get('/customer/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
        Route::get('/customer/book', [CustomerController::class, 'Trip'])->name('customer.book');
        Route::post('/customer/book', [CustomerController::class, 'bookTrip'])->name('customer.bookTrip');
        Route::get('/customer/trips', [CustomerController::class, 'viewTrips'])->name('view.trip');
        Route::get('/customer/trips/approve/{trip}', [CustomerController::class, 'approveTrip'])->name('customer.approveTrip');
        Route::get('/customer/trips/cancel/{trip}', [CustomerController::class, 'cancelTrip'])->name('customer.cancelTrip');
        Route::get('customer/payment/{tripId}', [CustomerController::class, 'makePayment'])->name('customer.makePayment');
        Route::post('customer/payment/{tripId}', [CustomerController::class, 'storePayment'])->name('customer.storePayment');

    });


    Route::middleware(['auth', 'role:super-admin'])->group(function () {
        Route::get('super-admin/dashboard', [SuperAdminCompanyController::class, 'dashboard'])->name('super-admin.dashboard');
        Route::get('super-admin/companies', [SuperAdminCompanyController::class, 'viewCompanies'])->name('super-admin.companies');
        Route::get('super-admin/companies/create', [SuperAdminCompanyController::class, 'addCompany'])->name('super-admin.add');
        Route::post('super-admin/companies', [SuperAdminCompanyController::class, 'storeCompany'])->name('super-admin.store');
        Route::get('super-admin/companies/edit/{id}', [SuperAdminCompanyController::class, 'editCompany'])->name('super-admin.edit');
        Route::put('super-admin/companies/{id}', [SuperAdminCompanyController::class, 'updateCompany'])->name('super-admin.update');
        Route::delete('super-admin/companies/{id}', [SuperAdminCompanyController::class, 'destroyCompany'])->name('super-admin.destroy');


    });


    //profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [AuthController::class, 'changePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    //users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/inactive', [UserController::class, 'inactive'])->name('users.inactive');
    Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');


    //roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole'])->name('roles.add-permission');
    Route::post('roles/{roleId}/permissions', [RoleController::class, 'givePermissionToRole'])->name('roles.givePermissionToRole');


   //permissions
   Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
   Route::get('/permissions/create', [PermissionController::class, 'create'])->name('permissions.create');
   Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');


   //Reports
   Route::get('/reports/successful-trips', [ReportController::class, 'successfulTrips'])->name('reports.successful');
   Route::get('/reports/unsuccessful-trips', [ReportController::class, 'unsuccessfulTrips'])->name('reports.unsuccessful');
   Route::get('/reports/driver-reports', [ReportController::class, 'driverIncomeReport'])->name('driver.report');

});
