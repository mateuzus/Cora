<?php

namespace App\Http\Controllers\Api;

use App\Entities\Listing;
use App\Http\Controllers\Controller;
use App\Http\Requests\ListingCreateRequest;
use App\Repositories\ListingRepository;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ListingController extends Controller
{
    /**
     * @var ListingRepository
     */
    private $repository;
    /**
     * @var Listing
     */
    private $listing;

    /**
     * ListingController constructor.
     * @param ListingRepository $repository
     * @param Listing $listing
     */
    public function __construct(ListingRepository $repository, Listing $listing)
    {
        $this->repository = $repository;
        $this->listing = $listing;
    }

    /**
     * @OA\Get(
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="tipo de filas",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *              enum="[prices, flow_of_work, prices, audits, pops, routines, noncompliances, resupplements]"
     *         )
     *     ),
     *     tags={"Listas"},
     *     summary="Listas de hoje",
     *     description="Retorna as listas cadastradas no dia de hoje ",
     *     path="/api/v1/questions",
     *     @OA\Response(response="200", description="{'data':[]}"),
     * )
     */
    public function index(Request  $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $type = $request->type;
        $listings = Listing::orderBy('status')
            ->today();
        switch ($type){
            case 'flow_of_work':
                $listings->listingWork();
                break;
            case 'prices':
                $listings->listingPrice();
                break;
            case 'audits':
                $listings->listingAudits();
                break;
            case 'pops':
                $listings->listingPops();
                break;
            case 'routines':
                $listings->listingRoutines();
                break;
            case 'noncompliances':
                $listings->listingNoncompliances();
                break;
            case 'resupplements':
                $listings->listingResupplements();
                break;

        }
        return response()->json(['data'=>$listings->get()]);

    }






    /**
     * @OA\Post(
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="usuário que irá executar a lista",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="descrição da lista",
     *         required=true,
     *         @OA\Schema(
     *          type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="creation_date",
     *         in="query",
     *         description="data de criação da lista",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="tipo de filas, onde determinatá qual será o tipo de fila",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *              enum="[prices, flow_of_work, prices, audits, pops, routines, noncompliances, resupplements]"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="tags da lista",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="period_end",
     *         in="query",
     *         description="fim do periodo da lista",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="period_start",
     *         in="query",
     *         description="inicio do periodo da lista",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="list_tag",
     *         in="query",
     *         description="tags da lista para auxiliar na pesquisa",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pop_id",
     *         in="query",
     *         description="id do pop a ser cadastrado",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="routine_id",
     *         in="query",
     *         description="id da rotina a ser cadastrada",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="flow_id",
     *         in="query",
     *         description="id do fluxo a ser cadastrado",
     *         required=false,
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     tags={"Listas"},
     *     summary="Retorna uma lista cadastrada",
     *     description="Retorna lista",
     *     path="/api/v1/listings",
     *     @OA\Response(response="200", description=""),
     * ),
     *
     */
    public function store(ListingCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $listing = $this->repository->create($request->all());

            $response = [
                'message' => 'Lista cadastrada.',
                'data'    => $listing->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }
}
