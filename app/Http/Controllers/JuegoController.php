<?php

namespace App\Http\Controllers;

use App\Models\Admin\Juego;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Juegos",
 *     required={"nombre", "descripcion"},
 *     @OA\Property(property="nombre", type="string", example=""),
 *     @OA\Property(property="descripcion", type="string", example=""),
 * ),
 *  @OA\Tag(
 *    name="Juegos",
 *    description="Juegos"
 * )
 */
class JuegoController extends Controller
{

 /**
 * @OA\Get(
 *     path="/api/eventos/lista-juego",
 *     summary="Listar Juegos",
 *     security={{ "bearerAuth": {} }},
 *     description="Reguest",
 *     operationId="index",
 *     tags={"Juegos"},
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
    public function index()
    {
        $juego = Juego::all();
        return response()->json($juego);
    }

    /**
     * @OA\Get(
     *     path="/api/eventos/lista-juego/{idJuego}",
     *     summary="Listar Juego",
     *     security={{ "bearerAuth": {} }},
     *     operationId="showJuegoId",
     *     tags={"Juegos"},
     *     @OA\Parameter(
     *         name="idJuego",
     *         in="path",
     *         required=true,
     *         description="ID del Juego",
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
    public function showJuegoId($idJuego)
    {
        if (empty($idJuego)) {
            return response()->json(['error' => true, 'msg' => 'Data not found', 'data' => null], 400);
        }
        $juego = Juego::find($idJuego);

        return response()->json([
            'data'  => $juego,
            'msg'   => 'Consulta exitosa',
            'error' => false
            ] , 200);
    }

    /**
     * @OA\Post(
     *     path="/api/eventos/create-juego",
     *     summary="Crear Juego",
     *     security={{ "bearerAuth": {} }},
     *     operationId="storeJuego",
     *     tags={"Juegos"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request",
     *         @OA\JsonContent(ref="#/components/schemas/Juegos"),
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
    public function storeJuego(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $juego = Juego::create($request->all());

        return response()->json([
            'data'  => $juego,
            'msg'   => 'Datos Guardados Correctamente',
            'error' => false
            ] , 201);
    }
    
   
       /**
     * @OA\Put(
     *     path="/api/eventos/update-juego/{idJuego}",
     *     summary="Actualizar Juego",
     *     security={{ "bearerAuth": {} }},
     *     operationId="update",
     *     tags={"Juegos"},
     *     @OA\Parameter(
     *         name="idJuego",
     *         in="path",
     *         required=true,
     *         description="ID del Juego",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request",
     *         @OA\JsonContent(ref="#/components/schemas/Juegos"),
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
    public function update(Request $request, $idJuego)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([ 
                  'data'    => null,
                  'msg'     => $validator->errors(),
                  'error'   => true
                ], 400);
        }

        $juego = Juego::find($idJuego);

        if (!$juego) {
            return response()->json([ 
            'data'  => null,
            'msg'   => 'No Existe Juego',
            'error' => true
        ], 404);
        }

        $juego->update($request->all());

        return response()->json([
            'data'  => $juego,
            'msg'   => 'Datos Modificados Correctamente',
            'error' => false
            ] , 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/eventos/eliminar-juego/{idJuego}",
     *     summary="Eliminar Juego",
     *     security={{ "bearerAuth": {} }},
     *     operationId="destroy",
     *     tags={"Juegos"},
     *     @OA\Parameter(
     *         name="idJuego",
     *         in="path",
     *         required=true,
     *         description="ID del Juego",
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
    public function destroy($idJuego)
    {
        try {
            $juego = Juego::findOrFail($idJuego);
            $juego->delete();
            return response()->json([
                'data'  => $idJuego,
                'msg'   => 'Registro Eliminado Correctamente',
                'error' => false
                ] , 200);
        } catch (\Exception $e) {
            return response()->json([
                'data'  => $idJuego,
                'msg'   => 'No se pudo eliminar el registro',
                'error' => true
                ] , 400);
        }
    }
}