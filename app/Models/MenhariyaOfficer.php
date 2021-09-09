<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Laravel\Passport\HasApiTokens;

class MenhariyaOfficer extends User
{
    use HasFactory,  HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'working_route', 
        'password',
    ];
}
