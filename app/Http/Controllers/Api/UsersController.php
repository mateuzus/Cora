<?php

namespace App\Http\Controllers\Api;


use App\Entities\User;
use App\Http\Controllers\Controller;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use OpenApi\Annotations as OA;


class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    protected $validator;

    /**
     * UsersController constructor.
     *
     * @param UserRepository $repository
     * @param UserValidator $validator
     */
    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * @OA\Get(
     *     @OA\Parameter(
     *         name="network_id",
     *         in="query",
     *         description="id do usuario de rede",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     tags={"Listagem de Usuários"},
     *     summary="Retorna um usuário autenticado com seus recursos e token",
     *     description="Retorna usuário, perfil, token, rede, lojas ",
     *     path="/api/v1/users",
     *     @OA\Response(response="200", description="{'data':[{'id':11,'name':'Gerente de Marketing','email':'gerente_de_marketing@teste.com','email_verified_at':'2021-04-10 12:04:11','status':true,'created_at':'2021-04-10T15:04:11.000000Z','updated_at':'2021-04-10T15:04:11.000000Z'}]}"),
     * )
     */
    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $network =$request->network_id;

        $users = User::withoutAdmin()
            ->active()
            ->usersNetWork($network)
            ->get();
        return response()->json([
            'data' => $users,
        ]);


    }
}
