<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class DetalleJuego extends Model
{
    protected $table = 'detalleJuego'; 

    protected $primaryKey = 'idDetalleJ'; 

    protected $fillable = [
        'idDetalleJ', 
        'idEvento',
        'idJuego',
        'fechIni',
        'fechFin',
        'flag',
        'idUsuario',
    ];

    public $incrementing = true; 

 public static function listarDetalleJuego(){
    
    $resultados = DB::select(" SELECT 
                                    dj.idDetalleJ,
                                    e.idEvento,
                                    e.nombre as evento,
                                    j.idJuego,
                                    j.nombre as Juego,
                                    dj.fechIni as fechaInicio,
                                    dj.fechFin  as fechaFinal,
                                    dj.flag
                                    FROM detalleJuego as dj
                                    INNER JOIN evento as e on(e.idEvento = dj.idEvento)
                                    INNER JOIN juego as j on(j.idJuego = dj.idJuego)
                                    WHERE dj.flag = 1");

        return  $resultados;

 }

 public static function listarDetalleJuegoId($idDetalleJuego){
    
    $resultados = DB::select(" SELECT 
                                    dj.idDetalleJ,
                                    e.idEvento,
                                    e.nombre as evento,
                                    j.idJuego,
                                    j.nombre as Juego,
                                    dj.fechIni as fechaInicio,
                                    dj.fechFin  as fechaFinal,
                                    dj.flag
                                    FROM detalleJuego as dj
                                    INNER JOIN evento as e on(e.idEvento = dj.idEvento)
                                    INNER JOIN juego as j on(j.idJuego = dj.idJuego)
                                    WHERE dj.flag = 1 and dj.idDetalleJ = ? ", [$idDetalleJuego]);

        return  $resultados;

 }

}