<?php

namespace App\Http\Controllers\Api;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use OpenApi\Annotations as OA;
/**
 * @OA\Info(
 *     version="1.0",
 *     title="API DE EXECUÇÃO DO MUFFATO"
 * )
 */

class ApiAuthController extends Controller
{

    /**
     * @OA\Post(
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="maximum number of results to return",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     tags={"Autenticação"},
     *     summary="Retorna um usuário autenticado com seus recursos e token",
     *     description="Retorna usuário, perfil, token, rede, lojas ",
     *     path="/api/v1/login",
     *     @OA\Response(response="200", description="{OK}"),
     * ),
     *
     */
    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = [
                    'user' => $user,
                    'roles'=>$user->roles,
                    'network'=>$user->network,
                    'stores'=>$user->stores,
                    'access_token' => $token,
                    'token_type' => "bearer",
                    'expire_in'=>3600,
                ];
                return response($response, 200);
            } else {
                $response = ["message" => "Senha inválida"];
                return response($response, 422);
            }
        } else {
            $response = ["message" =>'Usuário não encontrado'];
            return response($response, 422);
        }
    }
    /**
     * @OA\Post(
     *     tags={"Autenticação"},
     *     summary="Deloga usuário ",
     *     description="Retorna usuário, perfil, token, rede, lojas ",
     *     path="/api/v1/logout",
     *     @OA\Response(response="200", description="{}"),
     * ),
     *
     */

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
