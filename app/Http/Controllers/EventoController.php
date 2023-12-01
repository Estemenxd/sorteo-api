<?php

namespace App\Http\Controllers;

use App\Models\Admin\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Eventos",
 *     required={"nombre","idUsuario"},
 *     @OA\Property(property="nombre", type="string"),
 *     @OA\Property(property="idUsuario", type="integer"),
 * ),
 *  @OA\Tag(
 *    name="Eventos",
 *    description="Eventos"
 * )
 */
class EventoController extends Controller
{

 /**
 * @OA\Get(
 *     path="/api/eventos/lista-evento",
 *     summary="Listar Eventos",
 *     security={{ "bearerAuth": {} }},
 *     description="Reguest",
 *     operationId="listarEvento",
 *     tags={"Eventos"},
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
    public function listarEvento()
    {
        $juego = Evento::all();
        return response()->json($juego);
    }

    /**
     * @OA\Get(
     *     path="/api/eventos/lista-evento/{idEvento}",
     *     summary="Listar Evento por ID",
     *     security={{ "bearerAuth": {} }},
     *     operationId="showEventoId",
     *     tags={"Premios"},
     *     @OA\Parameter(
     *         name="idEvento",
     *         in="path",
     *         required=true,
     *         description="ID del Premio",
     *         @OA\Schema(type="integer")
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
    public function showEventoId($idEvento)
    {
        if (empty($idEvento)) {
            return response()->json(['error' => true, 'msg' => 'Data not found', 'data' => null], 400);
        }
        $data = Evento::find($idEvento);

        return response()->json([
            'data'  => $data,
            'msg'   => 'Consulta exitosa',
            'error' => false
            ] , 200);
    }

    /**
     * @OA\Post(
     *     path="/api/eventos/create-evento",
     *     summary="Crear Evento",
     *     security={{ "bearerAuth": {} }},
     *     operationId="storeEvento",
     *     tags={"Eventos"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request",
     *         @OA\JsonContent(ref="#/components/schemas/Eventos"),
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
    public function storeEvento(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'idUsuario' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $data = Evento::create($request->all());

        return response()->json([
            'data'  => $data,
            'msg'   => 'Datos Guardados Correctamente',
            'error' => false
            ] , 201);
    }
    
   
       /**
     * @OA\Put(
     *     path="/api/eventos/update-evento/{idEvento}",
     *     summary="Actualizar Evento",
     *     security={{ "bearerAuth": {} }},
     *     operationId="updateEvento",
     *     tags={"Eventos"},
     *     @OA\Parameter(
     *         name="idEvento",
     *         in="path",
     *         required=true,
     *         description="ID del Evento",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request",
     *         @OA\JsonContent(ref="#/components/schemas/Eventos"),
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
    public function updateEvento(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'idUsuario' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([ 
                  'data'    => null,
                  'msg'     => $validator->errors(),
                  'error'   => true
                ], 400);
        }

        $dataDb = Evento::find($id);

        if (!$dataDb) {
            return response()->json([ 
            'data'  => null,
            'msg'   => 'No Existe Juego',
            'error' => true
        ], 404);
        }

        $dataDb->update($request->all());

        return response()->json([
            'data'  => $dataDb,
            'msg'   => 'Datos Modificados Correctamente',
            'error' => false
            ] , 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/eventos/eliminar-evento/{idEvento}",
     *     summary="Eliminar Evento",
     *     security={{ "bearerAuth": {} }},
     *     operationId="destroyEvento",
     *     tags={"Eventos"},
     *     @OA\Parameter(
     *         name="idEvento",
     *         in="path",
     *         required=true,
     *         description="ID del Evento",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="datos Elimnados Correctamente",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validación",
     *     ),
     * )
     */
    public function destroyEvento($id)
    {
        try {
            $juego = Evento::findOrFail($id);
            $juego->delete();
            return response()->json([
                'data'  => $id,
                'msg'   => 'Registro Eliminado Correctamente',
                'error' => false
                ] , 200);
        } catch (\Exception $e) {
            return response()->json([
                'data'  => $id,
                'msg'   => 'No se pudo eliminar el registro',
                'error' => true
                ] , 400);
        }
    }
}