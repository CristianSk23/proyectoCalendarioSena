<?php

namespace App\Models\fotografiasEvento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Evento\Evento;

class FotografiaEvento extends Model
{
    use HasFactory;

    protected $table = 'fotografiasEvento';

    protected $primaryKey = 'idFotografia';

    public $timestamps = false;

    protected $fillable = [
        'idEvento',
        'ruta',
    ];

    // Relación correctamente definida
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'idEvento', 'idEvento');
    }


    public function fotosEvento()
    {
        return $this->hasMany(\App\Models\fotografiasEvento\FotografiaEvento::class, 'idEvento', 'idEvento');
    }



   

public function obtenerFotosMesActual()
{
    $inicioMes = Carbon::now()->startOfMonth();
    $finMes = Carbon::now()->endOfMonth();

    return FotografiaEvento::with('evento')
        ->whereHas('evento', function ($query) use ($inicioMes, $finMes) {
            $query->whereBetween('fecha', [$inicioMes, $finMes]);
        })
        ->get();
}


}
