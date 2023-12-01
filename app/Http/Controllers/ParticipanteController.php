<?php

namespace App\Http\Controllers;

use App\Models\Participante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Participantes",
 *     required={"codigo", "nroDocumento"},
 *     @OA\Property(property="codigo", type="string", example=""),
 *     @OA\Property(property="nroDocumento", type="string", example=""),
 * ),
 *  @OA\Tag(
 *    name="Participantes",
 *    description="Participantes"
 * )
 */
class ParticipanteController extends Controller
{

   /**
     * @OA\Get(
     *     path="/api/eventos/search-participante/{codigo}/{documento}",
     *     summary="Listar Participante por DNI o Codigo",
     *     security={{ "bearerAuth": {} }},
     *     operationId="searchParticipante",
     *     tags={"Participantes"},
     *     @OA\Parameter(
     *         name="codigo",
     *         in="path",
     *         required=false,
     *         description="Codigo del Participante",
     *         @OA\Schema(type="string")
     *     ),
     *    @OA\Parameter(
     *         name="documento",
     *         in="path",
     *         required=false,
     *         description="Número Documento del Participante",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="datos actualizado correctamente",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validación",
     *     ),
     * )
     */
    public function searchParticipante($codigo, $documento)
    {
        if (empty($codigo)  && empty($documento)) {
            return response()->json(['error' => true, 'msg' => 'Data not found', 'data' => null], 400);
        }
        try {
        $codigoContri = ""; 
        if(!empty($codigo)){
            $codigoContri = str_pad($codigo, 10, '0', STR_PAD_LEFT);
        }    

        $data = Participante::searchParticipante($codigoContri, $documento);
         
        if(!empty($data)){
            return response()->json([
                'data'  => $data,
                'msg'   => 'Participa en el Sorteo',
                'error' => false
                ] , 200);
        }else{
            return response()->json([
                'data'  => null,
                'msg'   => 'No Participa en el Sorteo',
                'error' => false
                ] , 200);
        }
        } catch (\Exception $e) {
            return response()->json([
                'data'  => null,
                'msg'   => 'Ups! Ocurrio un Problema Intentelo mas Tarde',
                'error' => true
                ] , 400);
        }
    }

     /**
 * @OA\Get(
 *     path="/api/eventos/sortear-participantes",
 *     summary="Sortear Participante",
 *     security={{ "bearerAuth": {} }},
 *     description="Reguest",
 *     operationId="sortearParticipante",
 *     tags={"Participantes"},
 *     @OA\Response(
 *         response=200,
 *         description="Respuesta exitosa"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No encontrado"
 *     )
 * )
 */
public function sortearParticipante(){
    
    try {

        $participanteAleatorio  = Participante::sortearParticipante();

        if (!empty($participanteAleatorio)) {
            return response()->json([
                'data'  => $participanteAleatorio,
                'msg'   => 'Tenemos un Ganador',
                'error' => false
                ] , 200);
         
        } else {
            return response()->json([
                'data'  => null,
                'msg'   => 'No Exite Ganador',
                'error' => false
                ] , 200);
        }

    } catch (\Exception $e) {
        return response()->json([
            'data'  => null,
            'msg'   => 'Intentelo Otra Vez',
            'error' => true
            ] , 400);
    }
    }

 /**
 * @OA\Get(
 *     path="/api/eventos/lista-participantes/{elementosPorPagina}",
 *     summary="Listar Participantes",
 *     security={{ "bearerAuth": {} }},
 *     description="Reguest",
 *     operationId="getParticipante",
 *     tags={"Participantes"},
 *     @OA\Parameter(
 *         name="elementosPorPagina",
 *         in="path",
 *         required=false,
 *         description="Elementos por Pagina",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Respuesta exitosa"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="No encontrado"
 *     )
 * )
 */
public function getParticipante($elementosPorPagina = 10){

    $datosPaginados = Participante::paginate($elementosPorPagina);

    // Obtener el total de páginas
    $totalPaginas = $datosPaginados->lastPage();

    return response()->json([
        'data'  => $datosPaginados,
        'totalPaginas' => $totalPaginas,
        'elementosPorPagina' => $elementosPorPagina,
        'msg'   => 'Consulta exitosa',
        'error' => false
        ] , 200);

    }

}
