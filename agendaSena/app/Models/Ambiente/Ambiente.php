<?php

namespace App\Models\Ambiente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    use HasFactory;

    protected $table = 'sep_planeacion_ambiente'; // Nombre de la tabla
    protected $primaryKey = 'pla_amb_id'; // Clave primaria
    public $timestamps = false; // falso no tiene $timestamps

    protected $fillable = [
        'pla_amb_id',
        'pla_amb_descripcion',
        'pla_amb_num_aprendices',
        'pla_amb_tipo',
        'par_id_coordinador',
        'pla_amb_suma_horas',
        'pla_amb_estado',
    ];
}