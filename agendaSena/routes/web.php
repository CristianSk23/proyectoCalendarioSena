<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Horario\HorarioController;
use App\Http\Controllers\Evento\EventoController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\CalendarioController;


//index



Route::get('/', [CalendarioController::class, 'generarCalendario'])->name('calendario.index')/* ->middleware('auth') */;



//+++++  ===  Horarios  === +++++
Route::resource('horarios', HorarioController::class);

// Route::get('/', function () {
//     return redirect()->route('horarios.index');
// });





//+++++ === EVENTO  ===  +++++



//Route::resource('eventos', EventoController::class)/* ->middleware('auth') */;
Route::get('index', [EventoController::class, 'index'])->name('eventos.index')/* ->middleware('auth') */;
Route::post('crearPost', [EventoController::class, 'store'])->name('eventos.store')/* ->middleware('auth') */;
Route::get('buscar', [EventoController::class, 'buscarEventos'])->name('eventos.buscar')/* ->middleware('auth') */;
Route::get("crear", [EventoController::class, 'create'])->name('eventos.crearEvento');

// Route::get('/', function () {
//     return redirect()->route('eventos.index');
// });



//  ++++ CALENDARIO  ++++++
//Route::resource('eventos', EventoController::class)->middleware('auth');;
Route::get("calendario", [CalendarioController::class, 'generarCalendario'])->name('calendario.generar');

//  ++++ LOGIN  ++++++

Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('loginIngresar', [LoginController::class, 'login'])->name('login.ingresar');
Route::post('logout', [LoginController::class, 'logout'])->name('login.logout');
