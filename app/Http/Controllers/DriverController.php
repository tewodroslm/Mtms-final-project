<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Driver;
use App\Models\Ticket;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;

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

    
    ## validating the cnaceled boolean is creating an issue

    public function buyTicket(Request $request){
        
        //$driver = $request->user();
        
        $validate = Validator::make($request->all(), [ 
            'starting_point' => 'required|string',
            'destination' => 'required|string',
            'amount' => 'required',
            'driver_id' => 'required|integer',
            'canceled' => 'required'
        ]);
        
        if ($validate->fails()) {
            return response()->json(['Error'=>"Error has occured during validation"]);
        }
        
        $ticket = Ticket::create($validate);

        return response([
            'Message' => 'Ticket created successfuly',
            'Ticket' => $ticket,
        ]);

    }

    public function cancelTicket(Request $request){

        # retrieve the ticket using #id from $request
        # update cancelTicket to True

        $ticket = DB::table('tickets')
              ->where('id', $request->ticket_id)
              ->update(['canceled' => 1]); 

        return response([
            'Message' => 'Ticket updated successfully',
            'Ticket' => $ticket,
        ]);

    }

    public function payFine(Request $request){
        
        $validate = $request->validate([  
            'amount' => 'integer',
            'driver_id' => 'integer',
        ]);
        
        $payment = Payment::create($validate);

        return response([
            "Message" => "Successfuly paid",
            "Payment" => $payment,
        ]);
    }

}
