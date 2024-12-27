<?php

namespace App\Models\Horario;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ambiente\Ambiente;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horario'; 

    protected $primaryKey = 'idHora'; 

    public $timestamps = false; 

    protected $fillable = [
        'pla_amb_id',
        'inicio',
        'fin',
        'estadoHora',
    ];

    public function ambiente()

    {

        return $this->belongsTo(Ambiente::class, 'pla_amb_id', 'pla_amb_id'); // clave foránea vinculada

    }
}