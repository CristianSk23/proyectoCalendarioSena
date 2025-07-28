<?php

namespace App\Models\Participante;

use App\Models\Evento\Evento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Participante extends Authenticatable
{
    use HasFactory;

    // Especifica la tabla si no sigue la convención de nombres
    protected $table = 'sep_participante';

    // Especifica la clave primaria si no es 'id'
    protected $primaryKey = 'par_identificacion';

    // Si la clave primaria no es un entero, establece esto en false
    public $incrementing = false;

    // Si la clave primaria no es un entero, establece el tipo de la clave
    protected $keyType = 'string';

    // Especifica los campos que se pueden asignar masivamente
    protected $fillable = [
        'par_identificacion',
        'par_identificacion_actual',
        'par_nombres',
        'par_apellidos',
        'par_direccion',
        'par_telefono',
        'par_correo',
        'par_contrasena',
        'est_apr_id',
        'rol_id',
        'beneficio_sena',
        'par_horas_semanales',
        'par_tipo_poblacion',
    ];


    public $timestamps = false; 

    public function getAuthPassword()
    {
        return $this->par_contrasena;
    }
    public function getAuthIdentifierName()
    {
        return 'par_correo'; // Especifica que 'par_correo' es el campo utilizado para la autenticación
    }

    public function eventos()
    {
        return $this->belongsToMany(Evento::class, 'evento_participante', 'par_identificacion', 'evento_id');
    }
}
