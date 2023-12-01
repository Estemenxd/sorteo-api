<?php

namespace App\Http\Controllers;

use App\Models\DetalleJuego;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="DetalleJuego",
 *     required={"idEvento","idJuego", "fechIni", "fechFin", "idUsuario"},
 *     @OA\Property(property="idEvento", type="integer"),
 *     @OA\Property(property="idJuego", type="integer"),
 *     @OA\Property(property="fechIni", type="date"),
 *     @OA\Property(property="fechFin", type="date"),
 *     @OA\Property(property="idUsuario", type="integer"),
 * ),
 *  @OA\Tag(
 *    name="DetalleJuego",
 *    description="DetalleJuego"
 * )
 */
class DetalleJuegoController extends Controller
{

 /**
 * @OA\Get(
 *     path="/api/eventos/lista-detalle-juego",
 *     summary="Listar Detalle Juego",
 *     security={{ "bearerAuth": {} }},
 *     description="Reguest",
 *     operationId="listarDetalleJuego",
 *     tags={"DetalleJuego"},
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
    public function listarDetalleJuego()
    {
        try{

            $data = DetalleJuego::listarDetalleJuego();
            
            if(!empty($data)){
                return response()->json([
                    'data'  => $data,
                    'msg'   => 'Datos exitosa',
                    'error' => false
                    ] , 200);
            }else{
                return response()->json([
                    'data'  => null,
                    'msg'   => 'No existe Registros',
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
     *     path="/api/eventos/listar-detalle-juegoID/{idDetalleJuego}",
     *     summary="Listar Detalle Juego por ID",
     *     security={{ "bearerAuth": {} }},
     *     operationId="listarDetalleJuegoId",
     *     tags={"DetalleJuego"},
     *     @OA\Parameter(
     *         name="idDetalleJuego",
     *         required=true,
     *         in="path",
     *         required=false,
     *         description="Id del Detalle de Juego",
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
    public function listarDetalleJuegoId($idDetalleJuego)
    {
        if (empty($idDetalleJuego)) {
            return response()->json(['error' => true, 'msg' => 'Data not found', 'data' => null], 400);
        }

        try{

            $data = DetalleJuego::listarDetalleJuegoId($idDetalleJuego);
            
            if(!empty($data)){
                return response()->json([
                    'data'  => $data,
                    'msg'   => 'Datos exitosa',
                    'error' => false
                    ] , 200);
            }else{
                return response()->json([
                    'data'  => null,
                    'msg'   => 'No existe Registros',
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
     * @OA\Post(
     *     path="/api/eventos/create-detalle-juego",
     *     summary="Crear Detalle Juego",
     *     security={{ "bearerAuth": {} }},
     *     operationId="storeDetalleJuego",
     *     tags={"DetalleJuego"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request",
     *         @OA\JsonContent(ref="#/components/schemas/DetalleJuego"),
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
    public function storeDetalleJuego(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'idEvento'      => 'required',
            'idJuego'       => 'required',
            'fechIni'       => 'required',
            'fechFin'       => 'required',
            'idUsuario'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $data = DetalleJuego::create($request->all());

        return response()->json([
            'data'  => $data,
            'msg'   => 'Datos Guardados Correctamente',
            'error' => false
            ] , 201);

    }
    

        /**
     * @OA\Put(
     *     path="/api/eventos/update-detalle-juego/{idDetalleJ}",
     *     summary="Actualizar Detalle Juego",
     *     security={{ "bearerAuth": {} }},
     *     operationId="updateDetalleJuego",
     *     tags={"DetalleJuego"},
     *     @OA\Parameter(
     *         name="idDetalleJ",
     *         in="path",
     *         required=true,
     *         description="ID detalle Juego",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request",
     *         @OA\JsonContent(ref="#/components/schemas/DetalleJuego"),
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
    public function updateDetalleJuego(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'idEvento'      => 'required',
            'idJuego'       => 'required',
            'fechIni'       => 'required',
            'fechFin'       => 'required',
            'idUsuario'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([ 
                  'data'    => null,
                  'msg'     => $validator->errors(),
                  'error'   => true
                ], 400);
        }

        $dataDb = DetalleJuego::find($id);

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
     * @OA\Put(
     *     path="/api/eventos/eliminar-detalle-juego/{idDetalleJ}",
     *     summary="Eliminar Detalle Juego",
     *     security={{ "bearerAuth": {} }},
     *     operationId="destroyDetalleJuego",
     *     tags={"DetalleJuego"},
     *     @OA\Parameter(
     *         name="idDetalleJ",
     *         in="path",
     *         required=true,
     *         description="ID detalle Juego",
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
    public function destroyDetalleJuego($id)
    {
        if (empty($idDetalleJuego)) {
            return response()->json(['error' => true, 'msg' => 'Data not found', 'data' => null], 400);
        }
        
        try {
            $dataDb = DetalleJuego::where('idDetalleJ', $id)->update(['flag' => 0]);

            return response()->json([
                'data'  => $dataDb,
                'msg'   => 'Datos Eliminados Correctamente',
                'error' => false
                ] , 200);
        } catch (\Exception $e) {
                return response()->json([
                    'data'  => null,
                    'msg'   => 'No se pudo eliminar el registro',
                    'error' => true
                    ] , 400);
        }

    }



}
