<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TPoliceController extends Controller
{
    //
    public function testPolice(Request $request){
        // $driver = auth()->driver(); 
        $traffic = $request->user(); 

        return response()->json([
            'message' => 'TESTing ... ..',
            'driver' => $traffic, 
        ]);
    }

    public function checkDriver(Request $request){

        $validate = $request->validate([
            'licence' => 'required|string',
        ]);

        $driver = Driver::where('licence', $request->licence)->first();

            // TO DO
        // Retrieve the from where/when the driver departed 
        // Return weather the driver has start it's journy from the bus station

        return response()->json([
            'Message' => ' 200 Success!',
            'driver' => $driver,
        ]);

    }

    public function fineDriver(Request $request){

        $validate = $request->validate([
            'licence' => 'required|string',
            'violation' => 'required|string',
        ]);

        $traffic = $request->user(); 

        // TO DO
        // Create a fine (Fine table should have a foreign key to driver, tpolice)

        return response()->json([
            'Message' => '200 Successuly complited',
        
        ]);

    } 
    
    public function previousCrimeRecord(Request $request){

        $validate = $request->validate([
            'licence' => 'required|string', 
        ]);

        // TO DO
        // Retrieve all the fines the driver has paid

        return response()->json([
            'Message' => '200 Successfuly',
            
        ]);

    }

}
