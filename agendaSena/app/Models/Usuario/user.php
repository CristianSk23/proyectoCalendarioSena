<?php

namespace App\Models\Usuario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users_agenda'; // Cambia aquí si tu tabla se llama diferente

    protected $fillable = [
        'par_identificacion',
        'par_nombres',
        'par_apellidos',
        'email',
        'password',
        'estado',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'par_identificacion';
    }
}
