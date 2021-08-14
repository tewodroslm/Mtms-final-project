<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Driver;
use App\Models\TrafficPolice;

class Fine extends Model
{
    use HasFactory;
    protected $fillable = [
        'reason',
        'amount',
        'driver_id',
        'location'
    ];

    public function driver(){
        return $this->belongsTo(Driver::class);
    } 

    public function traffic_police(){
        return $this->belongsTo(TrafficPolice::class);
    }

}
