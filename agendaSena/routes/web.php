<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Horario\HorarioController;
use App\Http\Controllers\Evento\EventoController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\Evento\ReporteController;
use App\Http\Controllers\PDFController;

//index


Route::get('/', [CalendarioController::class, 'generarCalendario'])->name('calendario.index')/* ->middleware('auth') */;


//+++++  ===  Horarios  === +++++
Route::resource('horarios', HorarioController::class);

// Route::get('/', function () {
//     return redirect()->route('horarios.index');
// });




//+++++ === EVENTO  ===  +++++

//Route::resource('eventos', EventoController::class)/* ->middleware('auth') */;
Route::get('evento/index', [EventoController::class, 'index'])->name('eventos.index')/* ->middleware('auth') */;
Route::post('evento/crearPost', [EventoController::class, 'store'])->name('eventos.store')/* ->middleware('auth') */;
Route::get('evento/buscar', [EventoController::class, 'buscarEventos'])->name('eventos.buscar')/* ->middleware('auth') */;
Route::get("evento/crear", [EventoController::class, 'create'])->name('eventos.crearEvento');

Route::get("evento/editar/{idEvento}", [EventoController::class, 'edit'])->name('eventos.editarEvento');
Route::post("evento/actualizar/{idEvento}", [EventoController::class, 'update'])->name('eventos.actualizarEvento');

Route::get("evento/eliminar/{idEvento}", [EventoController::class, 'delete'])->name('eventos.eliminarEvento');

Route::get("cargarParticipantes", [EventoController::class, 'cargarParticipantes'])->name('eventos.buscarParticipantes');

// Route::get('/', function () {
//     return redirect()->route('eventos.index');
// });


//  ++++ CALENDARIO  ++++++
//Route::resource('eventos', EventoController::class)->middleware('auth');;
Route::get("calendario", [CalendarioController::class, 'generarCalendario'])->name('calendario.generar');
Route::get("calendario/buscarEventos", [CalendarioController::class, 'buscarEventosPorMes'])->name('calendario.buscarEventos');

//  ++++ LOGIN  ++++++

Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('loginIngresar', [LoginController::class, 'login'])->name('login.ingresar');
Route::post('logout', [LoginController::class, 'logout'])->name('login.logout');




//**** reportes*** */


Route::get('evento/reportes', [ReporteController::class, 'index_report'])->name('evento.reportes.index');
// Route::post('evento/reportes/generar-mensual', [ReporteController::class, 'generarReporteMensual'])->name('reportes.mensual');
// Route::post('evento/reportes/generar-anual', [ReporteController::class, 'generarReporteAnual'])->name('reportes.anual');



Route::post('/reportes/mensual', [ReporteController::class, 'generarReporteMensual'])->name('reportes.mensual');
Route::post('/reportes/anual', [ReporteController::class, 'generarReporteAnual'])->name('reportes.anual');
Route::get('/reportes/filtrar', [ReporteController::class, 'filtrarReportes'])->name('reportes.filtrar');



// ************* PDF ********************
    
Route::get('generate-pdf', [PDFController::class, 'generatePDF']);


