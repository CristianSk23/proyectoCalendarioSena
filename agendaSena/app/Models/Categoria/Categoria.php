<?php

namespace App\Models\Categoria;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categoria'; // Nombre de la tabla

    protected $primaryKey = 'idCategoria'; // Clave primaria

    public $timestamps = false; // Si no usas timestamps

    protected $fillable = [
        'nomCategoria',
        'descripcion',
        'estadoCategoria',
    ];
}