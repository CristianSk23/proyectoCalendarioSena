<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'users'; 
    protected $primaryKey = 'id'; 

    protected $fillable = [
        'par_identificacion', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed', //para hashear la contraseña
    ];

    public function getAuthIdentifierName()
    {
        return 'par_identificacion';
    }
}


