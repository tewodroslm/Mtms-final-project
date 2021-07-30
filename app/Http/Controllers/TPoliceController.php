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
    
}
