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

    public function latestTicket(Request $request){

        $validate = $request->validate([
            'licence' => 'required|string',
        ]);

        $driver = Driver::where('licence', $request->licence)->first();
        
       
        $matchThese = ['driver_id' => $driver->id];

        $lastTicket = Ticket::where($matchThese)->whereDate('created_at', date('Y-m-d'))->get();
        return response()->json([
            'Latest ticket' => $lastTicket,
        ]);
    }

    public function buyTicket(Request $request){
        
        //$driver = $request->user();
        
        
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
