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
        
        $validate = Validator::make($request->all(), [ 
            'starting_point' => 'required|string',
            'destination' => 'required|string',
            'amount' => 'required',
            'driver_id' => 'required|integer',
            'canceled' => 'required'
        ]);

        $errors = $validate->errors();
        
        if ($validate->fails()) {
            return response()->json([
                'Error'=>"Error has occured during validation",
                'error' => $errors->all(),
            ]);
        }

        $matchThese = ['driver_id' => $request->driver_id];

        $lastTicket = Ticket::where($matchThese)->latest()->first();
        
        if(isset($lastTicket->canceled)){
            if($lastTicket->canceled == 0){
                return response()->json([
                    'Message' => 'Cancle || finish with your destination',
                    'lastTicket' => $lastTicket,
                ]);
            }  
        }
              
        
        $ticket = Ticket::create($request->all());

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
            'Message' => 'Ticket canceled successfully',
            'Ticket' => $ticket,
        ]);

    }

    public function getUnCanceledTicket(Request $request){

        $matchThese = ['driver_id' => $request->driver_id];

        $lastTicket = Ticket::where($matchThese)->latest()->first();
        return response([
            'Message' => 'Ticket created successfuly', 
            'Ticket' => $lastTicket,
        ]);

    }

    public function payFine(Request $request){
        
        $validate = $request->validate([  
            'amount' => 'integer',
            'driver_id' => 'integer',
            'bank_account' => 'string',
        ]);
        
        $payment = Payment::create($validate);

        return response([
            "Message" => "Successfuly paid",
            "Payment" => $payment,
        ]);
    }

}
