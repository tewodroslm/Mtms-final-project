<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrafficPolice;
use App\Models\Driver;
use Illuminate\Support\Facades\Validator;
use App\Models\MenhariyaOfficer;

class AdminController extends Controller
{
   
     // Register Traffic police (done by admin)

     public function registerTrafficPolice(Request $request){
        
        $validate = $request->validate([
            'name' => 'required|string',
            'traffic_id' => 'required|integer|unique:traffic_police',
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

     // Register Menhariya officer  (done by admin)

     public function registerMenhariyaOfficer(Request $request){
        
        $validate = $request->validate([ 
            'name' => 'required|string', 
            'working_route' => 'string',  
            'email' => 'required|email',
            'password' => 'required|min:4|confirmed'
        ]);

        $validate['password'] = bcrypt($request->password);
        
        $menhariyaOfficer = MenhariyaOfficer::create($validate);

        $accessToken = $menhariyaOfficer->createToken('authToken')->accessToken;

        return response([
            'MenhariyaOfficer' => $menhariyaOfficer,
            'access_token' => $accessToken
        ]);

     }

     // get mofficers
     public function mOfficers(Request $request){
         $mOfficers = MenhariyaOfficer::all();
         return response([
             'Status' => 'Success',
             'mofficers' => $mOfficers
         ]);
     }

     // get Tpolices
     public function tPolices(Request $request){
         $tpolices = TrafficPolice::all();
         return response([
            'Status' => 'Success',
            'tpolices' => $tpolices
         ]);
     }

     public function driversAll(Request $request){
         $drivers = Driver::all();
         return response([
             'Status' => 'Success',
             'drivers' => $drivers
         ]);
     }
}
