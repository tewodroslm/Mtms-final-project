<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use App\Models\User;

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

    public function getAuthPassword()
    {
     return $this->password;
    }

}
