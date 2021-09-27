<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\Report;
use App\Models\Payment;

class MenhariyaOfficerController extends Controller
{
    // TO DO .. functions that menhariya officers are or have to <do!!! class=""></do!!!>

    public function checkDriver(Request $request){

        $validate = $request->validate([
            'licence' => 'required|string',
        ]);

        $driver = Driver::where('licence', $request->licence)->first();
    
        $matchThese = ['driver_id' => $driver->id];

        $ticket = Ticket::where($matchThese)->whereDate('created_at', date('Y-m-d'))->get();
 
        return response()->json([
            'Message' => ' 200 Success!',
            'driver' => $driver,
            'list ticket' => [ $ticket]
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

    public function getAllDriver(){
        $drivers = Driver::all();
        return response()->json([
            'drivers' => $drivers
        ]);
    }

    public function totalVehicle(){
       
        $drivers = Driver::all();
        $total = sizeof($drivers);
        return response()->json([
            'drivers' => $drivers,
            'total' => $total,
            
        ]);
    }

    public function departedVehichle(){
        $user = Auth::user();
        $location = $user->working_route;

        // get drivers deprated from this mofficer location 
            
        $matchThese = ['starting_point' => $location];

        $ticket = Ticket::where($matchThese)->whereDate('created_at', date('Y-m-d'))->get();

        return response()->json([
            'tickets' => $ticket,
            'total' => sizeof($ticket)
        ]);
    }

    public function toCurrentStaion(){
        $user = Auth::user();
        $location = $user->working_route;
        $matchThese = ['destination' => $location];

        $ticket = Ticket::where($matchThese)->whereDate('created_at', date('Y-m-d'))->get();
        
        if(sizeof($ticket) !=0){    
            return response()->json([
                'tickets' => $ticket,
                'total' => sizeof($ticket)
            ]);
        }else{
            return response()->json([
                'Error' => 'Mof location not known' 
            ]);
        }        
    }

    public function updateStatus(Request $request){
        $validate = $request->validate([
            'licence' => 'required|string',
        ]);

        $driver = Driver::where('licence', $request->licence)->first();
        $driver->status = 'suspended';
        $driver->save();
        return response()->json([
            'status' => 'updated'
        ]);
    }


    public function dPayments(Request $request){
        $validate = $request->validate([
            'licence' => 'required|string',
        ]);

        $driver = Driver::where('licence', $request->licence)->first();
        $payments = Payment::where('driver_id', $driver->id)->get();
        return response()->json([
            'payments' => $payments, 
        ]);
    }
    
}
