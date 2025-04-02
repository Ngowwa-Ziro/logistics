<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;

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
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/set-password', [AuthController::class, 'showSetPasswordForm'])->name('setPasswordForm');
    Route::post('/set-password', [AuthController::class, 'setPassword'])->name('setPassword');


   //Trips
   Route::get('/trips', [TripController::class, 'index'])->name('trips.index');
   Route::get('/trips/book', [TripController::class, 'create'])->name('trips.create');
   Route::post('/trips/book', [TripController::class, 'store'])->name('trips.book');
   Route::post('/trips/{id}/cancel', [TripController::class, 'cancel'])->name('trips.cancel');
   Route::post('/trips/{id}/approve', [TripController::class, 'approve'])->name('trips.approve');




Route::middleware(['auth:web', 'user.status'])->group(function(){

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

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


   //Trips
   Route::get('/trips', [TripController::class, 'index'])->name('trips.index');
   Route::get('/trips/book', [TripController::class, 'create'])->name('trips.create');
   Route::post('/trips/book', [TripController::class, 'store'])->name('trips.book');
   Route::post('/trips/{id}/cancel', [TripController::class, 'cancel'])->name('trips.cancel');
   Route::post('/trips/{id}/approve', [TripController::class, 'approve'])->name('trips.approve');

});
