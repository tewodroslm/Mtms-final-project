<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request; 
use App\Models\Driver;

class AuthController extends Controller
{
    
    // Register driver
    public function registerDriver(Request $request){

        $validate = $request->validate([
            'licence' => 'required|string|unique:drivers',
            'name' => 'required|string',
            'working_route' => 'string',
            'driver_type' => 'integer',
            'car_owner' => 'boolean',
            'password' => 'required|min:4|confirmed'
        ]);

        $validate['password'] = bcrypt($request->password);
        
        $driver = Driver::create($validate);

        $accessToken = $driver->createToken('authToken')->accessToken;

        return response([
            'driver' => $driver,
            'access_token' => $accessToken
        ]);

    }

    public function loginDriver(Request $request){
        $validate = $request->validate([
            'licence' => 'required|string',
            'password' => 'required'
        ]);
 
        $driver = Driver::where('licence', $request->licence)->first();

        if (!Hash::check($request->password, $driver->password)){

            return response(['error' => 'Invalid credentials']);
        }
        
        // if(!Auth::attempt($validate)){
            
        // }
        
        $accessToken = $driver->createToken('authToken')->accessToken;

        return response([
            'driver' => $driver, 
            'access_token' => $accessToken
        ]);
    }

}
