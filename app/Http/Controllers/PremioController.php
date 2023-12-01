<?php

namespace App\Http\Controllers;

use App\Models\Admin\Premio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Premios",
 *     required={"nombre","idUsuario"},
 *     @OA\Property(property="nombre", type="string"),
 *     @OA\Property(property="idUsuario", type="integer"),
 * ),
 *  @OA\Tag(
 *    name="Premios",
 *    description="Premios"
 * )
 */
class PremioController extends Controller
{

 /**
 * @OA\Get(
 *     path="/api/eventos/lista-premio",
 *     summary="Listar Premios",
 *     security={{ "bearerAuth": {} }},
 *     description="Reguest",
 *     operationId="listarPremio",
 *     tags={"Premios"},
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
    public function listarPremio()
    {
        $data = Premio::all();
        return response()->json($data);
    }

    /**
     * @OA\Get(
     *     path="/api/eventos/lista-premio/{idPremio}",
     *     summary="Listar Premio por ID",
     *     security={{ "bearerAuth": {} }},
     *     operationId="showPremioId",
     *     tags={"Premios"},
     *     @OA\Parameter(
     *         name="idPremio",
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
    public function showPremioId($idPremio)
    {
        if (empty($idPremio)) {
            return response()->json(['error' => true, 'msg' => 'Data not found', 'data' => null], 400);
        }
        $data = Premio::find($idPremio);

        return response()->json([
            'data'  => $data,
            'msg'   => 'Consulta exitosa',
            'error' => false
            ] , 200);
    }

    /**
     * @OA\Post(
     *     path="/api/eventos/create-premio",
     *     summary="Crear Premio",
     *     security={{ "bearerAuth": {} }},
     *     operationId="storePremio",
     *     tags={"Premios"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request",
     *         @OA\JsonContent(ref="#/components/schemas/Premios"),
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
    public function storePremio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'idUsuario' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $data = Premio::create($request->all());

        return response()->json([
            'data'  => $data,
            'msg'   => 'Datos Guardados Correctamente',
            'error' => false
            ] , 201);
    }
    
   
       /**
     * @OA\Put(
     *     path="/api/eventos/update-premio/{idPremio}",
     *     summary="Actualizar Premio",
     *     security={{ "bearerAuth": {} }},
     *     operationId="updatePremio",
     *     tags={"Premios"},
     *     @OA\Parameter(
     *         name="idPremio",
     *         in="path",
     *         required=true,
     *         description="ID del Premio",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request",
     *         @OA\JsonContent(ref="#/components/schemas/Premios"),
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
    public function updatePremio(Request $request, $id)
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

        $dataDb = Premio::find($id);

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
     *     path="/api/eventos/eliminar-premio/{idPremio}",
     *     summary="Eliminar Juego",
     *     security={{ "bearerAuth": {} }},
     *     operationId="destroyPremio",
     *     tags={"Premios"},
     *     @OA\Parameter(
     *         name="idPremio",
     *         in="path",
     *         required=true,
     *         description="ID del Premio",
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
    public function destroyPremio($id)
    {
        try {
            $juego = Premio::findOrFail($id);
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