<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Ticket;
use App\Models\Fine;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TPoliceController extends Controller
{
    
    public function checkDriver(Request $request){

        $validate = $request->validate([
            'licence' => 'required|string',
        ]);

        $driver = Driver::where('licence', $request->licence)->first();
        
            // TO DO
        // Retrieve the from where/when the driver departed 
        // Return weather the driver has start it's journy from the bus station              [OK DONE]

        $matchThese = ['driver_id' => $driver->id];

        $ticket = Ticket::where($matchThese)->whereDate('created_at', date('Y-m-d'))->get();
 
        return response()->json([
            'Message' => ' 200 Success!',
            'driver' => $driver,
            'list ticket' => [ $ticket]
        ]);

    }

    public function fineDriver(Request $request){

        $validate = $request->validate([ 
            'reason' => 'required|string',
            'driver_id' => 'required|integer',       
            'amount' => 'integer|required',
            'location' => 'string',
        ]);
        
        $traffic = $request->user(); 
        $validate['traffic_police_id'] = $traffic->id;

        // TO DO
        // Create a fine (Fine table should have a foreign key to driver, tpolice)
        // also [amount, location]                                                         [OK DONE]                 

        $fine = Fine::create($validate);

        return response()->json([
            'Message' => '200 Successuly complited',
            'Fine' => $fine,
            'Police id' => $traffic,
        ]);

    } 
    
    public function previousCrimeRecord(Request $request){

        $validate =  Validator::make($request->all(),[
            'driver_id' => 'required|integer', 
        ]);
        
        if ($validate->fails()) {
            return response()->json(['Error'=>"Empty driver id!"]);
        }
         
        // TO DO
        // Retrieve all the fines the driver has paid and all the reports on him    [DONE]

        $fine = DB::table('fines')->where('driver_id', $request->driver_id)->get(); 

        return response()->json([
            'Message' => '200 Successfuly',
            'record' => $fine
        ]);

    }

    public function getReport(Request $request){
        $validate = $request->validate([
            'platenumber' => 'required|string'
        ]);
        
        $reports = Report::where('platenumber', $request->platenumber)->get();

        return response()->json([
            'Message' => '200 success',
            'reports' =>  $reports
        ]);
    }

    // Report Driver
    public function reportDriver(Request $request){
        $validate = $request->validate([
            'platenumber' => 'required|string',
            'place' => 'required|string',
            'traffic_police_id' => 'required',
            'reason' => 'required|string'
        ]);

        $fine = Report::create($request->all());                
        return response()->json([
            'Message' => 'success',
            'report' => $fine
        ]);
    }

} 