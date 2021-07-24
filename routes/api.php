<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

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

Route::post("/register-driver", [AuthController::class, 'registerDriver']);
Route::post("/login-driver", [AuthController::class, 'loginDriver']);

Route::middleware('auth:api')->group(function (){
    // Route::get("/register", [Api\AuthController::class, 'register']);
});  