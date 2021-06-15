<?php

namespace App\Http\Controllers;

use App\Entities\Network;
use App\Entities\NetworkConfig;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NetworkConfigCreateRequest;
use App\Http\Requests\NetworkConfigUpdateRequest;
use App\Repositories\NetworkConfigRepository;
use App\Validators\NetworkConfigValidator;

/**
 * Class NetworkConfigsController.
 *
 * @package namespace App\Http\Controllers;
 */
class NetworkConfigsController extends Controller
{
    /**
     * @var NetworkConfigRepository
     */
    protected $repository;

    /**
     * @var NetworkConfigValidator
     */
    protected $validator;

    /**
     * NetworkConfigsController constructor.
     *
     * @param NetworkConfigRepository $repository
     * @param NetworkConfigValidator $validator
     */
    public function __construct(NetworkConfigRepository $repository, NetworkConfigValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));

        if(Auth::user()->isSuperAdmin()){
            $networks = Network::all();
        }else{
            $networks = Auth::user()->networks;
        }

        $network_configs = $this->repository->findWhereIn('network_id', $networks->pluck('id')->toArray());

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $network_configs,
            ]);
        }

        return view('network_configs.index', compact('network_configs'));
    }

    public function create(){
        if(Auth::user()->isSuperAdmin()){
            $networks = Network::all()->pluck('description', 'id');
        }else{
            $networks = Network::whereIn('id', Auth::user()->network->pluck('id'))->pluck('description', 'id');
        }
        return view('network_configs.create', compact('networks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NetworkConfigCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(NetworkConfigCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $networkConfig = $this->repository->create($request->all());

            $response = [
                'message' => 'Regra de negócio cadastrado com sucesso.',
                'data'    => $networkConfig->toArray(),
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

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $networkConfig = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $networkConfig,
            ]);
        }

        return view('network_configs.show', compact('networkConfig'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $networkConfig = $this->repository->find($id);
        $networks = Network::all()->pluck('description', 'id');
        $price_lowering_rules = NetworkConfig::all()->pluck('price_lowering_rules', 'id');
        return view('network_configs.edit', compact('networkConfig', 'networks', 'price_lowering_rules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NetworkConfigUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(NetworkConfigUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $networkConfig = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Regra de negócio atualizado com sucesso.',
                'data'    => $networkConfig->toArray(),
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'NetworkConfig deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'NetworkConfig deleted.');
    }
}
