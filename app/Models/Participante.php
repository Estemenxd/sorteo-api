<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Participante extends Model
{
    protected $table = 'participante'; 

    protected $primaryKey = 'idParticipante'; 

    protected $fillable = [
        'codigo',
        'idTipoDoc',
        'nroDocumento',
        'aPaterno',
        'aMaterno',
        'nombres',
        'rsocial',
        'direccion',
        'celular',
        'correo',
        'flag',
        'estado',
        'idUsuario',
    ];

    public $incrementing = true; 

    public static function searchParticipante($codigo, $documento){

        $resultados = DB::select("SELECT 
                        codigo,
                        nroDocumento,
                        CONCAT(aPaterno, ' ', aMaterno) as Apellidos, 
                        nombres
                        FROM participante WHERE idTipoDoc = 1 AND  codigo = ?
                         OR  nroDocumento = ?",  [$codigo, $documento]);

        return  $resultados;

    }

   public static function sortearParticipante(){

    $participante = DB::table('participante')
            ->select('idParticipante', 'codigo', 'nroDocumento', 'aPaterno', 'aMaterno', 'nombres', 'celular', 'correo', 'direccion') 
            ->where('estado', '=', 0)
            ->where('idTipoDoc', '=', 1)
            ->whereNotIn('idParticipante', function ($query) {
                $query->select('idParticipante')->from('detalleParticipante')
                ->where('flag', '=', 1);
            })
            ->inRandomOrder()
            ->first();
            
     return $participante;
    
   } 

}