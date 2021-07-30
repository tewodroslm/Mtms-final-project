<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Ticket;

class TPoliceController extends Controller
{
    
    public function checkDriver(Request $request){

        $validate = $request->validate([
            'licence' => 'required|string',
        ]);

        $driver = Driver::where('licence', $request->licence)->first();
        
            // TO DO
        // Retrieve the from where/when the driver departed 
        // Return weather the driver has start it's journy from the bus station              [OK]

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
            'driver_account_number' => 'integer',
            'amount' => 'integer|required',
            'location' => 'string',
        ]);
        
        $traffic = $request->user(); 
        $validate['trafficpolice_id'] = $traffic->id;

        // TO DO
        // Create a fine (Fine table should have a foreign key to driver, tpolice)
        // also [amount, account, location]

        $fine = Fine::create($validate);

        return response()->json([
            'Message' => '200 Successuly complited',
            'Fine' => $fine,
        ]);

    } 
    
    public function previousCrimeRecord(Request $request){

        $validate = $request->validate([
            'driver_id' => 'required|integer', 
        ]);

        // TO DO
        // Retrieve all the fines the driver has paid

        

        return response()->json([
            'Message' => '200 Successfuly',
            
        ]);

    }

}
