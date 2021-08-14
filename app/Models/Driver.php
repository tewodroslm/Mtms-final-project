<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use App\Models\User;
use App\Models\Fine;
use App\Models\Ticket;
use App\Models\Report;
use App\Models\Payment;

class Driver extends User
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'name',
        'licence',
        'working_route',
        'driver_type',
        'car_owner',
        'password',
    ];
 
    public function fines(){
        return $this->hasMany(Fine::class);
    }

    public function tickets(){
        return $this->hasMany(Ticket::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function reports(){
        return $this->hasMany(Report::class);
    }
}
