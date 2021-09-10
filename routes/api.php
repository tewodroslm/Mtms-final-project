<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\TPoliceController;
use App\Http\Controllers\MenhariyaOfficerController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/add-admin", [AuthController::class, 'addAdmin']);
Route::post("/login-admin", [AuthController::class, 'adminLogin']);

Route::post("/register-driver", [AuthController::class, 'registerDriver']);
Route::post("/login-driver", [AuthController::class, 'loginDriver']);

Route::post("/login-tpolice", [AuthController::class, 'loginTraffic']);
Route::post("/login-mofficer", [AuthController::class, 'menhariyaOfficerLogin']);

// Done by driver
Route::middleware('auth:api-drivers')->group(function (){
    Route::get("/testDriver", [DriverController::class, 'testDriver']);
    Route::post("/get-ticket", [DriverController::class, 'buyTicket']);
    Route::post("/cancel-ticket", [DriverController::class, 'cancelTicket']);
    Route::post("/pay-fine", [DriverController::class, 'payFine']);
});

// Done by Traffic police
Route::middleware("auth:api-police")->group(function(){
    Route::get("/testPolice", [TPoliceController::class, 'testPolice']);
    Route::post("/check-driver", [TPoliceController::class, 'checkDriver']);
    Route::post("/fine-driver", [TPoliceController::class, 'fineDriver']);
    Route::post("/crime-record", [TPoliceController::class, 'previousCrimeRecord']);
});

// Done by M - officer
Route::middleware("auth:api-mofficer")->group(function(){
    Route::get("/all-driver", [MenhariyaOfficerController::class, 'getAllDriver']);
    Route::post("/mocheckdriver", [MenhariyaOfficerController::class, 'checkDriver']);
    Route::get("/total", [MenhariyaOfficerController::class, 'totalVehicle']);
    Route::get("/departedfromhere", [MenhariyaOfficerController::class, 'departedVehichle']);
    Route::get("/toCurrentStaion", [MenhariyaOfficerController::class, 'toCurrentStaion']);
});

// Done by admin

Route::middleware('auth:api')->group(function (){
    // Route::get("/register", [Api\AuthController::class, 'register']);
    Route::middleware(['scope:add-traffic-police'])->post("/register-trafficpolice", [AdminController::class, 'registerTrafficPolice']);

    Route::middleware(['scope:add-menhariya-officer'])->post("/register-menhariyaOfficer", [AdminController::class, 'registerMenhariyaOfficer']);
});  

    // Route::middleware(['scope:admin,Ar2,Ar1'])->get('users', 'AddAdminUsers@getUsers');