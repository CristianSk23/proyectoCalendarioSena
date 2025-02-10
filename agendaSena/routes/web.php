<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Horario\HorarioController;
use App\Http\Controllers\Evento\EventoController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\Evento\ReportesController;


//index

Route::get('/', [CalendarioController::class, 'index'])->name('calendario.index')/* ->middleware('auth') */;



//+++++  ===  Horarios  === +++++
Route::resource('horarios', HorarioController::class);

// Route::get('/', function () {
//     return redirect()->route('horarios.index');
// });





//+++++ === EVENTO  ===  +++++

Route::resource('eventos', EventoController::class)->middleware('auth');
Route::get('buscar', [EventoController::class, 'buscarEventos'])->name('eventos.buscar')/* ->middleware('auth') */;

// Route::get('/', function () {
//     return redirect()->route('eventos.index');
// });



//  ++++ CALENDARIO  ++++++
//Route::resource('eventos', EventoController::class)->middleware('auth');;


//  ++++ LOGIN  ++++++

Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('loginIngresar', [LoginController::class, 'login'])->name('login.ingresar');
Route::post('logout', [LoginController::class, 'logout'])->name('login.logout');



Route::prefix('evento/reportes')->name('evento.reportes.')->group(function () {
    Route::get('/', [ReportesController::class, 'index'])->name('index');
    Route::get('/{id}', [ReportesController::class, 'show'])->name('show');
});
