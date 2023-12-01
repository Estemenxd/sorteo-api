<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Usuario",
 *     required={"usuario", "clave"},
 *     @OA\Property(property="usuario", type="string", example=""),
 *     @OA\Property(property="clave", type="string", example=""),
 * ),
 *  @OA\Tag(
 *    name="Usuarios",
 *    description="Usuarios"
 * )
 */
class AuthController extends Controller
{
     /**
    * @OA\Get(
        *     path="/api/eventos/login",
        *     summary="Listar Usuarios",
        *     security={{ "bearerAuth": {} }},
        *     description="Descripción detallada de la ruta",
        *     operationId="geUsuarios",
        *     tags={"Usuarios"},
        *     @OA\RequestBody(
        *         required=true,
        *        description="Datos para crear un nuevo ejemplo",
        *        @OA\JsonContent(ref="#/components/schemas/Usuario"),
        *    ),
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
    public function geUsuarios()
    {
        $users = User::all();
        return  $users;
    }
    

       /**
     * @OA\Post(
     *     path="/api/eventos/login",
     *     summary="Login Obtener Token",
     *     operationId="authenticate",
     *     tags={"Usuarios"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Request",
     *         @OA\JsonContent(ref="#/components/schemas/Usuario"),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="creado exitosamente",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación",
     *     ),
     * )
     */
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usuario' => 'required',
            'clave' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $result  = User::login($request['usuario'], $request['clave']);
        if (!empty($result) && count($result) > 0) {
            if ($result[0]->flag == 1){
                $auth = User::where('usuario', $result[0]->usuario)->first();

                $token = JWTAuth::fromUser($auth);

                return response()->json([
                    'data' => $result,
                    'token' =>  $token,
                    'msg' => 'Consulta exitosa',
                    'error' => false,
                ],200);
            }else{
                return response()->json([
                    'data' => 'Usuario y/o Contraseña Incorrecto',
                    'msg' => 'Consulta exitosa',
                    'error' => true,
                ],401);
            }
        
        }

        return response()->json([
            'data' => null,
            'msg' => 'Usuario y/o Contraseña Incorrecto',
            'error' => true],401);
    }
}

