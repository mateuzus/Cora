<?php

namespace App\Http\Controllers;

use App\Entities\Network;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\StoreCreateRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Repositories\StoreRepository;
use App\Validators\StoreValidator;

/**
 * Class StoresController.
 *
 * @package namespace App\Http\Controllers;
 */
class StoresController extends Controller
{
    /**
     * @var StoreRepository
     */
    protected $repository;

    /**
     * @var StoreValidator
     */
    protected $validator;

    /**
     * StoresController constructor.
     *
     * @param StoreRepository $repository
     * @param StoreValidator $validator
     */
    public function __construct(StoreRepository $repository, StoreValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $stores = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $stores,
            ]);
        }

        return view('stores.index', compact('stores'));
    }


    public function create(){

        if(Auth::user()->isSuperAdmin()){
            $networks = Network::all()->pluck('description', 'id');
        }else{
            $networks = Network::whereIn('id', Auth::user()->networks   ->pluck('id'))->pluck('description', 'id');
        }

        return view("stores.create", compact('networks'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(StoreCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $store = $this->repository->create($request->all());

            $response = [
                'message' => 'Loja cadastrada com sucesso',
                'data'    => $store->toArray(),
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
        $store = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $store,
            ]);
        }

        return view('stores.show', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $store = $this->repository->find($id);
        $networks = Network::all()->pluck('description', 'id');
        return view('stores.edit', compact('store', 'networks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(StoreUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $store = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Loja atualizada com sucesso',
                'data'    => $store->toArray(),
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
                'message' => 'Store deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Store deleted.');
    }
}
