<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)
            ->with([
                'roles',
                'networks',
                'stores',
                'teams',
                'departments',
            ])->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken(bcrypt($request->password))->accessToken;
                $response = [
                    'user' => $user,
                    'access_token' => $token,
                    'token_type' => "Bearer",
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
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }
}
