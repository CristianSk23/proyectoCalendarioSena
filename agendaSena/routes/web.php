<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Horario\HorarioController;
use App\Http\Controllers\Evento\EventoController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\Evento\ReporteController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Evento\ResponsableController;
use App\Http\Controllers\Public\PublicController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\FondoController;
use App\Http\Controllers\FotografiaEvento\FotografiaEventoController;


// Rutas públicas
Route::get('/', [PublicController::class, 'index'])->name('public.index');
Route::get('/public/{id}', [PublicController::class, 'show'])->name('public.show');

// Ruta del calendario (cambiada a /calendario)
Route::get('/calendario', [CalendarioController::class, 'generarCalendario'])->name('calendario.index')->middleware('auth');
Route::post('/calendario/diseno', [CalendarioController::class, 'subirMes'])->name('calendario.subirMes')->middleware('auth');

//+++++  ===  Horarios  === +++++
Route::resource('horarios', HorarioController::class);

//+++++ === EVENTO  ===  +++++
Route::post('evento/crearPost', [EventoController::class, 'store'])->name('eventos.store')->middleware('auth');
Route::get('evento/buscar', [EventoController::class, 'buscarEventos'])->name('eventos.buscar')->middleware('auth');
Route::get("evento/crear", [EventoController::class, 'create'])->name('eventos.crearEvento')->middleware('auth');

Route::get("evento/editar/{idEvento}", [EventoController::class, 'edit'])->name('eventos.editarEvento')->middleware('auth');
Route::post("evento/actualizar/{idEvento}", [EventoController::class, 'update'])->name('eventos.actualizarEvento')->middleware('auth');
Route::get("evento/eliminar/{idEvento}", [EventoController::class, 'delete'])->name('eventos.eliminarEvento')->middleware('auth');



Route::get("evento/PorConfirmar", [EventoController::class, 'eventosPorConfirmar'])->name('eventos.porConfirmar');
Route::get("evento/buscarParticipantes", [EventoController::class, 'buscarParticipantes'])->name('eventos.buscarParticipantes');
Route::get("evento/buscarAmbientes", [EventoController::class, 'buscarAmbientes'])->name('eventos.buscarAmbientes');
Route::get("evento/eventosPorNombre", [EventoController::class, 'buscarEventosPorNombre'])->name('eventos.buscarEventoPorNombre');
Route::post("evento/confirmarEvento", [EventoController::class, 'confirmarEvento'])->name('eventos.confirmarEvento');
//Route::get("eventosPorFecha", [EventoController::class, 'buscarEventosPorFecha'])->name('eventos.buscarEventoPorFecha');

// Evento soliictud publica
// Ruta para solicitudes públicas SIN autenticación completa
Route::post('evento/solicitud', [EventoController::class, 'store'])->name('evento.solicitud.store');
// Ruta protegida solo para usuarios logueados
// Route::post('evento/crearPost', [EventoController::class, 'store'])->name('eventos.store')->middleware('auth');


//+++++ === FOTOGRAFIAS EVENTO  ===  +++++
Route::get('evento/agregarFotos/{idEvento}', [FotografiaEventoController::class, 'paginaPrincinpal'])->name('eventos.agregarFotos')->middleware('auth');
Route::post('evento/agregarFotos/bd/{idEvento}', [FotografiaEventoController::class, 'create'])->name('eventos.agregarFotosBd')->middleware('auth');
Route::delete('evento/agregarFotos/eliminar/{idEvento}', [FotografiaEventoController::class, 'delete'])->name('eventos.eliminarFotosBd')->middleware('auth');


//  ++++ CALENDARIO  ++++++
Route::get("calendario/buscarEventos", [CalendarioController::class, 'buscarEventosPorMes'])->name('calendario.buscarEventos');


Route::get('/calendario-publico', [CalendarioController::class, 'generarCalendarioPublico'])->name('calendario.publico');



// Ruta para las categorías
Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');


//** */  ++++ LOGIN  ++++++
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('loginIngresar', [LoginController::class, 'login'])->name('login.ingresar');
Route::post('logout', [LoginController::class, 'logout'])->name('login.logout')->middleware('auth');

//**** reportes*** */
Route::get('evento/reportes', [ReporteController::class, 'index_report'])->name('evento.reportes.index')->middleware('auth');
Route::get('/reportes/filtrar', [ReporteController::class, 'filtrarEventos'])->name('evento.reportes.filtrar')->middleware('auth');
Route::get('/reportes/eventos/mes', [ReporteController::class, 'eventosMesJson'])->middleware('auth');
Route::get('/reportes/eventos/anio', [ReporteController::class, 'eventosAnioJson'])->middleware('auth');





Route::post('/reportes/mensual', [ReporteController::class, 'generarReporteMensual'])->name('reportes.mensual')->middleware('auth');
Route::post('/reportes/anual', [ReporteController::class, 'generarReporteAnual'])->name('reportes.anual')->middleware('auth');
Route::get('evento/reportes/filtrar', [ReporteController::class, 'filtrarReportes'])->name('reportes.filtrar')->middleware('auth');

// ************* PDF ********************
Route::get('generate-pdf', [PDFController::class, 'generatePDF']);

//********+responsable**** */
Route::get('/api/responsables', [ResponsableController::class, 'index']);

//******PDF REPORTES *************/
Route::post('/reportes/pdf/mensual', [PdfController::class, 'generarReporteMensual'])->name('reportes.pdf.mensual');





// // **  controlador de vista publica ******* */
// Route::get('/public', [PublicController::class, 'index'])->middleware('guest');



// se agrega vista e ecuestar para  solicitar evento
Route::get('/solicitud-evento', [EventoController::class, 'solicitudPublica'])->name('evento.solicitud');
Route::post('/evento/updatepublica/{evento}', [EventoController::class, 'updatePublica'])->name('evento.updatePublica');






Route::post('/verificar-credenciales', [LoginController::class, 'validarCredencialesPublicas'])->name('verificar-credenciales');





Route::post('/evento/store/externo', [EventoController::class, 'storeExterno'])->name('eventos.storeExterno');
// Route::get('/test-session-table', function () {
//     dd(config('session.table'));
// });

// validar ruta para solicitud eventos
//Route::post('/evento/publico/crear', [EventoPublicoController::class, 'validarUsuarioYCrear'])->name('evento.publico.validar');

// Validacion de usurio para solicitud de evento.
Route::post('/verificar-usuario', [EventoController::class, 'verificarUsuario'])->name('verificar.usuario');



//*Cambio de fondos pagina de login
Route::post('/fondos/subir', [FondoController::class, 'subir'])->name('fondos.subir');
Route::post('/fondos/seleccionar', [FondoController::class, 'seleccionar'])->name('fondos.seleccionar');
