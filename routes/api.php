<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\TPoliceController;
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

Route::post("/add-admin", [AuthController::class, 'addAdmin']);
Route::post("/login-admin", [AuthController::class, 'adminLogin']);

Route::post("/register-driver", [AuthController::class, 'registerDriver']);
Route::post("/login-driver", [AuthController::class, 'loginDriver']);

Route::post("/login-tpolice", [AuthController::class, 'loginTraffic']);

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

});


// Done by admin

Route::middleware('auth:api')->group(function (){
    // Route::get("/register", [Api\AuthController::class, 'register']);
    Route::middleware(['scope:add-traffic-police'])->post("/register-trafficpolice", [AdminController::class, 'registerTrafficPolice']);

    Route::middleware(['scope:add-menhariya-officer'])->post("/register-menhariyaOfficer", [AdminController::class, 'registerMenhariyaOfficer']);
});  

    // Route::middleware(['scope:admin,Ar2,Ar1'])->get('users', 'AddAdminUsers@getUsers');