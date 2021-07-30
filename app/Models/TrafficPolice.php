<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
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

}
