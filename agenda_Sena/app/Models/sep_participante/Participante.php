<?php

namespace App\Models\Participante;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
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
        'est_apr_id',
        'rol_id',
        'beneficio_sena',
        'par_horas_semanales',
        'par_tipo_poblacion',
    ];

    // Si tienes timestamps en tu tabla, habilita esto
    public $timestamps = false; // Cambia a true si tienes created_at y updated_at



    
}