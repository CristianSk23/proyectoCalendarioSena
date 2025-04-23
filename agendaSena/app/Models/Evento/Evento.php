<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Horario\Horario;
use App\Models\Categoria\categoria;
use App\Models\Ambiente\Ambiente;
use App\Models\Ficha\Ficha;
use App\Models\fotografiasEvento\FotografiaEvento;
use App\Models\sep_participante\Participante;

class Evento extends Model
{
    use HasFactory;

    protected $table = 'evento'; // Nombre de la tabla

    protected $primaryKey = 'idEvento'; // Clave primaria

    public $timestamps = false; // Si no usas timestamps

    protected $fillable = [
        'par_identificacion',
        'pla_amb_id',
        'idHorario', // Llave foránea para la relación con Horario
        'fechaEvento',
        'aforoEvento',
        'nomEvento',
        'descripcion',
        'fic_numero',
        'nomSolicitante',
        'idCategoria', // Llave foránea para la relación con Categoria
        'publicidad',
        'estadoEvento',
    ];

    // Relación con Horario
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'idHorario', 'idHora'); // Clave foránea vinculada
    }

    // Relación con Categoria (si existe)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria', 'idCategoria'); // Clave foránea vinculada
    }

    // Relación con Ambiente (si es necesario)
    public function ambiente()
    {
        return $this->belongsTo(Ambiente::class, 'pla_amb_id', 'pla_amb_id'); // Clave foránea vinculada
    }

    public function participante()
    {
        return $this->belongsTo(Participante::class, 'par_identificacion', 'par_identificacion'); // Clave foránea vinculada
    }

    public function ficha()
    {
        return $this->belongsTo(Ficha::class, 'fic_numero', 'fic_numero'); // Clave foránea vinculada
    }
   /*  public function fotografiasEvento()
    {
        return $this->belongsTo(FotografiaEvento::class, 'idEvento', 'idEvento'); // Clave foránea vinculada
    } */
}
