<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Repositories\OperationStandartRepository;
use App\Validators\OperationStandartValidator;
use Illuminate\Http\Request;

class OperationStandartsController extends Controller
{

    protected $repository;


    protected $validator;


    public function __construct(OperationStandartRepository $repository, OperationStandartValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * @OA\Get(
     *     @OA\Parameter(
     *         name="network_id",
     *         in="query",
     *         description="id da rede",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     tags={"Listagem de POPS"},
     *     summary="Pops Cadastrados",
     *     description="Retorna todas os pops cadastrados",
     *     path="/api/v1/pops",
     *     @OA\Response(response="200", description=""),
     * )
     */
    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $operationStandart = $this->repository->with(['roles','stores', 'departments', 'tasks'])->findWhere(['network_id'=> $request->network_id]);
        return response()->json([
            'data' => $operationStandart,
        ]);


    }

}
