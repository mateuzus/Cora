<?php

namespace App\Http\Controllers\Api;

use App\Entities\Flow;
use App\Entities\Network;
use App\Entities\Role;
use App\Entities\Store;
use App\Http\Controllers\Controller;
use App\Services\Workflow\DefaultBehaviorRegistry;
use App\Services\Workflow\ProcessBuilder;
use App\Services\Workflow\ProcessEngine;
use App\Services\Workflow\Token;
use App\Services\Workflow\Visual\BuildDigraphScript;
use App\Services\Workflow\Visual\VisualizeFlow;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FlowCreateRequest;
use App\Http\Requests\FlowUpdateRequest;
use App\Repositories\FlowRepository;
use App\Validators\FlowValidator;
use function App\Services\WorkflowValues\get_values;


class FlowsController extends Controller
{

    protected $repository;


    protected $validator;


    protected $flow;

    public function __construct(FlowRepository $repository, FlowValidator $validator, Flow $flow)
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
     *     tags={"Listagem de Fluxos"},
     *     summary="Fluxos Cadastrados",
     *     description="Retorna todas os fluxos cadastrados",
     *     path="/api/v1/flows",
     *     @OA\Response(response="200", description=""),
     * )
     */

    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $flows = $this->repository->findWhere(['network_id'=> $request->network_id]);


            return response()->json([
                'data' => $flows,
            ]);

    }
}
