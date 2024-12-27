<?php

namespace App\Models\Ficha;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ficha extends Model
{
    use HasFactory;

    // Especifica la tabla si el nombre no sigue la convención plural
    protected $table = 'sep_ficha';

    // Define los atributos que se pueden asignar masivamente
    protected $fillable = [
        'fic_numero',
        'prog_codigo',
        'cen_codigo',
        'fic_fecha_inicio',
        'fic_fecha_fin',
        'par_identificacion',
        'par_identificacion_vocero',
        'fic_estado',
        'fic_modalidad',
        'fic_localizacion',
        'fic_version_matriz',
        'act_version',
        'fic_proyecto',
        'par_identificacion_coordinador',
        'fic_duracion_lectiva',
        'fic_duracion_productiva',
        'par_identificacion_productiva',
        'fic_observacion',
        'fic_fecha_seguimiento',
        'fic_calificacion',
    ];
}