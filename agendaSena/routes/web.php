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
// use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\Categoria\CategoriaController;


// Rutas públicas
Route::get('/', [PublicController::class, 'index'])->name('public.index');
Route::get('/public/{id}', [PublicController::class, 'show'])->name('public.show');

// Ruta del calendario (cambiada a /calendario)
Route::get('/calendario', [CalendarioController::class, 'generarCalendario'])->name('calendario.index');

//+++++  ===  Horarios  === +++++
Route::resource('horarios', HorarioController::class);

//+++++ === EVENTO  ===  +++++
Route::post('evento/crearPost', [EventoController::class, 'store'])->name('eventos.store')/* ->middleware('auth') */;
Route::get('evento/buscar', [EventoController::class, 'buscarEventos'])->name('eventos.buscar')/* ->middleware('auth') */;
Route::get("evento/crear", [EventoController::class, 'create'])->name('eventos.crearEvento');

Route::get("evento/editar/{idEvento}", [EventoController::class, 'edit'])->name('eventos.editarEvento');
Route::post("evento/actualizar/{idEvento}", [EventoController::class, 'update'])->name('eventos.actualizarEvento');
Route::get("evento/eliminar/{idEvento}", [EventoController::class, 'delete'])->name('eventos.eliminarEvento');
Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');

Route::get("evento/PorConfirmar", [EventoController::class, 'eventosPorConfirmar'])->name('eventos.porConfirmar');
Route::get("cargarParticipantes", [EventoController::class, 'cargarParticipantes'])->name('eventos.buscarParticipantes');
Route::get("eventosPorNombre", [EventoController::class, 'buscarEventosPorNombre'])->name('eventos.buscarEventoPorNombre');
//Route::get("eventosPorFecha", [EventoController::class, 'buscarEventosPorFecha'])->name('eventos.buscarEventoPorFecha');



//  ++++ CALENDARIO  ++++++
Route::get("calendario/buscarEventos", [CalendarioController::class, 'buscarEventosPorMes'])->name('calendario.buscarEventos');

// // ***Yaque rutas por busqueda***  22-mar-2025
// Route::get('/buscar-eventos-por-dia', [CalendarioController::class, 'buscarEventosPorDia']);
// Route::get('/buscar-eventos-por-nombre', [CalendarioController::class, 'buscarEventosPorNombre']);
// Route::get('/buscar-eventos-por-lugar', [CalendarioController::class, 'buscarEventosPorLugar']);
// Route::get('/calendario-publico', [CalendarioController::class, 'generarCalendarioPublico']);
// // termine adicion d erutas por busqueda*** yaque****
// Route::get('/calendario-publico', [CalendarioController::class, 'generarCalendarioPublico'])->name('calendario.publico');
Route::get('/calendario-publico', [CalendarioController::class, 'generarCalendarioPublico'])->name('calendario.publico');



// Ruta para las categorías
// Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');


//  ++++ LOGIN  ++++++
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('loginIngresar', [LoginController::class, 'login'])->name('login.ingresar');
Route::post('logout', [LoginController::class, 'logout'])->name('login.logout');

//**** reportes*** */
Route::get('evento/reportes', [ReporteController::class, 'index_report'])->name('evento.reportes.index');
Route::post('/reportes/mensual', [ReporteController::class, 'generarReporteMensual'])->name('reportes.mensual');
Route::post('/reportes/anual', [ReporteController::class, 'generarReporteAnual'])->name('reportes.anual');
Route::get('/reportes/filtrar', [ReporteController::class, 'filtrarReportes'])->name('reportes.filtrar');

// ************* PDF ********************
Route::get('generate-pdf', [PDFController::class, 'generatePDF']);

//********+responsable**** */
Route::get('/api/responsables', [ResponsableController::class, 'index']);

//******PDF REPORTES *************/
Route::post('/reportes/pdf/mensual', [PdfController::class, 'generarReporteMensual'])->name('reportes.pdf.mensual');

// **  controlador de vista publica ******* */
Route::get('/public', [PublicController::class, 'index'])->middleware('guest');

//****EVENTOS¨*** */
Route::get('/buscarEventos', [EventoController::class, 'buscarEventos'])->name('eventos.buscar');

// Route::get('/categorias', [CategoriaController::class, 'getCategorias']);

// Route::get('/categorias', [CategoriaController::class, 'getCategorias'])->name('categorias.index');

// Route::get('/publica', [CategoriasController::class, 'mostrarVistaConCategorias'])->name('categorias.vista');





// Route::get('/eventos/categoria', [EventoController::class, 'buscarEventosPorCategoria'])->name('eventos.porCategoria');

// Route::get('/', [CategoriaController::class, 'mostrarVistaConCategorias'])->name('public.index');



// Route::get('/filtrar-eventos-categoria', [EventoController::class, 'filtrarPorCategoria'])->name('eventos.filtrar.categoria');
Route::get('/evento/{id}/detalle', [EventoController::class, 'detalleEvento'])->name('evento.detalle');
