<?php

use App\Http\Controllers\DetalleJuegoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ParticipanteController;
use App\Models\Participante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\PremioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('eventos')->group(function () {
     
    //Authentificacion  =>
    Route::post('login', [AuthController::class, 'authenticate']);

    //Buscar Participante si  participa en el Sorteo
    Route::get('search-participante/{codigo}/{documento}', [ParticipanteController::class, 'searchParticipante']);

    


    /**
     * Rutas Protegidas Token
     */
    Route::group(['middleware' => ['jwt.verify']], function() {

        Route::get('login', [AuthController::class, 'geUsuarios']);
        
        // Juegos 
        Route::get('lista-juego', [JuegoController::class, 'index']);
        Route::get('lista-juego/{idJuego}', [JuegoController::class, 'showJuegoId']);
        Route::post('create-juego', [JuegoController::class, 'storeJuego']);
        Route::put('update-juego/{idJuego}', [JuegoController::class, 'update']);
        Route::delete('eliminar-juego/{idJuego}', [JuegoController::class, 'destroy']);

        // Premio 
        Route::get('lista-premio', [PremioController::class, 'listarPremio']);
        Route::get('lista-premio/{idPremio}', [PremioController::class, 'showPremioId']);
        Route::post('create-premio', [PremioController::class, 'storePremio']);
        Route::put('update-premio/{idPremio}', [PremioController::class, 'updatePremio']);
        Route::delete('eliminar-premio/{idPremio}', [PremioController::class, 'destroyPremio']);

        // Eventos 
        Route::get('lista-evento', [EventoController::class, 'listarEvento']);
        Route::get('lista-evento/{idEvento}', [EventoController::class, 'showEventoId']);
        Route::post('create-evento', [EventoController::class, 'storeEvento']);
        Route::put('update-evento/{idEvento}', [EventoController::class, 'updateEvento']);
        Route::delete('eliminar-evento/{idEvento}', [EventoController::class, 'destroyEvento']);
        
        //Buscar Ganador Aleatoriamente
        Route::get('sortear-participantes', [ParticipanteController::class, 'sortearParticipante']);
        
        //Lista de Participantes
        Route::get('lista-participantes/{elementosPorPagina}', [ParticipanteController::class, 'getParticipante']);

        //Detalle Juego
        Route::get('lista-detalle-juego', [DetalleJuegoController::class, 'listarDetalleJuego']);
        Route::get('listar-detalle-juegoID/{idDetalleJ}', [DetalleJuegoController::class, 'listarDetalleJuegoId']);
        Route::post('create-detalle-juego', [DetalleJuegoController::class, 'storeDetalleJuego']);
        Route::put('update-detalle-juego/{idDetalleJ}', [DetalleJuegoController::class, 'updateDetalleJuego']);
        Route::put('eliminar-detalle-juego/{idDetalleJ}', [DetalleJuegoController::class, 'destroyDetalleJuego']);
        


    }); 

});
   
  


