<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request; 
use App\Models\Driver;
use App\Models\TrafficPolice;
use App\Models\MenhariyaOfficer;
use App\Models\User;
use App\Models\Admin;

class AuthController extends Controller
{
    
     // Add admin (uses the User model for auth and other stuff)
    public function addAdmin(Request $request){

        $validated = $request->validate([
            'name' => 'string',
            'email' => 'email|required',
            'password' => 'required|min:6|confirmed'
        ]);

        $validated['password'] = bcrypt($request->password);

        $userCreate = User::create($validated);

        $valAdmin= $request->validate([
            'name' => 'string',
            'email' => 'email|required'
        ]);

        $admin = Admin::create($valAdmin); 

        $accessToken = $userCreate->createToken('authToken')->accessToken;

        return response()->json([
            'Admin'=>$admin,
            'access_token' => $accessToken
            // 'Works' => "Testing... works"
        ]);

    }

     // Logging in admin

    public function adminLogin(Request $request){
        $cred = $validatedData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
     
        if( !auth()->attempt($cred)){
            return response(['message'=>'Invalid credentials']);
        }

        $admin = auth()->user(); 

        $token = $admin->createToken('authToken', ['add-traffic-police', 'add-menhariya-officer'])->accessToken;

        return response()->json([
            'token' => $token,
            'Admin' => $admin, 
        ]);
    }

    // Register driver
    public function registerDriver(Request $request){

        $validate = $request->validate([
            'licence' => 'required|string|unique:drivers',
            'name' => 'required|string',
            'working_route' => 'string',
            'driver_type' => 'integer',
            'car_owner' => 'boolean',
            'password' => 'required|min:4|confirmed',
            'car_plate_number' => 'required'
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


    
    //  Traffic police login

     public function loginTraffic(Request $request){
        $validate = $request->validate([
            'traffic_id' => 'required|integer',
            'password' => 'required'
        ]);
 
        $traffic = TrafficPolice::where('traffic_id', $request->traffic_id)->first();

        if (!Hash::check($request->password, $traffic->password)){

            return response(['error' => 'Invalid credentials']);
        }

        $accessToken = $traffic->createToken('authToken')->accessToken;

        return response([
            'Traffic' => $traffic, 
            'access_token' => $accessToken
        ]);
    }
    
    // Menhariya officer login
    public function menhariyaOfficerLogin(Request $request){
        $cred = $validatedData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);
        $officer = MenhariyaOfficer::where('email', $request->email)->first();

        if (!Hash::check($request->password, $officer->password)){

            return response(['error' => 'Invalid credentials']);
        }

        $accessToken = $officer->createToken('authToken')->accessToken;

        return response([
            'Mofficer' => $officer, 
            'access_token' => $accessToken
        ]); 
    }


}

