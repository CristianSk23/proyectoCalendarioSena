<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Horario\HorarioController;
use App\Http\Controllers\Evento\EventoController;

//index

Route::get('/', function () {

    return view('index'); // Vista principal

});



//+++++  ===  Horarios  === +++++
Route::resource('horarios', HorarioController::class);

// Route::get('/', function () {
//     return redirect()->route('horarios.index');
// });





//+++++ === EVENTO  ===  +++++

Route::resource('eventos', EventoController::class);

// Route::get('/', function () {
//     return redirect()->route('eventos.index');
// });



//  ++++ CALENDARIO  ++++++

Route::resource('eventos', EventoController::class);
