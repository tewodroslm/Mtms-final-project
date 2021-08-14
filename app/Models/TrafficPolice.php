<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Fine;
use Laravel\Passport\HasApiTokens;

class TrafficPolice extends User
{
    use HasFactory, HasApiTokens;
    
    protected $fillable = [
        'name',
        'traffic_id',
        'working_route', 
        'password',
    ];

    public function fines(){
        return $this->hasMany(Fine::class);
    }

}
