<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Horario\HorarioController;

// Route::get('/', function () {
//     return view('welcome');
// });

/// **** HORARIO ********///

Route::resource('horarios', HorarioController::class);
Route::get('/', function () {
    return redirect()->route('horarios.index');
});