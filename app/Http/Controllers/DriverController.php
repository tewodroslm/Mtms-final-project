<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    //  
    public function testDriver(Request $request){
        // $driver = auth()->driver(); 
        $driver = $request->user(); 

        return response()->json([
            'message' => 'TESTing ... ..',
            'driver' => $driver, 
        ]);
    }

    
    
    public function buyTicket(Request $request){
        
        $driver = $request->user();
        
        $validate = $request->validate([ 
            'starting_point' => 'string',
            'destination' => 'string',
            'amount' => 'integer',
            'driver_id' => 'integer',
            'cancled' => 'boolean'
        ]);

        $ticket = Ticket::create($validate);

        return response([
            'Message' => 'Ticket created successfuly',
            'Ticket' => $ticket,
        ]);

    }

    public function cancelTicket(Request $request){

        # retrieve the ticket using #id from $request
        # update cancelTicket to True
        
    }

    public function payFine(Request $request){

    }

}
