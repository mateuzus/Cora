<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RoutineCreateRequest;
use App\Http\Requests\RoutineUpdateRequest;
use App\Repositories\RoutineRepository;
use App\Validators\RoutineValidator;

/**
 * Class RoutinesController.
 *
 * @package namespace App\Http\Controllers;
 */
class RoutinesController extends Controller
{

    protected $repository;


    protected $validator;


    public function __construct(RoutineRepository $repository, RoutineValidator $validator)
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
     *     tags={"Listagem de Rotinas"},
     *     summary="Rotinas Cadastradas",
     *     description="Retorna todas as rotinas cadastradas ",
     *     path="/api/v1/routines",
     *     @OA\Response(response="200", description=""),
     * )
     */

    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        if (request()->wantsJson()) {
            $routines = $this->repository
                ->with([
                    'roles','stores', 'departments', 'tasks'
                ])
                ->findWhere(['network_id'=> $request->network_id]);
            return response()->json([
                'data' => $routines,
            ]);
        }

        return view('routines.index');
    }
}
