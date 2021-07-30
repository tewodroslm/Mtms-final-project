<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrafficPolice;

class AdminController extends Controller
{
   
     // Register Traffic police (done by admin)

     public function registerTrafficPolice(Request $request){
        
        $validate = $request->validate([ 
            'name' => 'required|string',
            'traffic_id' => 'required|string',
            'working_route' => 'string',  
            'password' => 'required|min:4|confirmed'
        ]);

        $validate['password'] = bcrypt($request->password);
        
        $trafficPolice = TrafficPolice::create($validate);

        $accessToken = $trafficPolice->createToken('authToken')->accessToken;

        return response([
            'TrafficPolice' => $trafficPolice,
            'access_token' => $accessToken
        ]);

     }



}
