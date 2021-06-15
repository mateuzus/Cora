<?php

namespace App\Http\Controllers;

use App\Entities\Network;
use App\Entities\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NetworkCreateRequest;
use App\Http\Requests\NetworkUpdateRequest;
use App\Repositories\NetworkRepository;
use App\Validators\NetworkValidator;

/**
 * Class NetworksController.
 *
 * @package namespace App\Http\Controllers;
 */
class NetworksController extends Controller
{
    /**
     * @var NetworkRepository
     */
    protected $repository;

    /**
     * @var NetworkValidator
     */
    protected $validator;

    /**
     * NetworksController constructor.
     *
     * @param NetworkRepository $repository
     * @param NetworkValidator $validator
     */
    public function __construct(NetworkRepository $repository, NetworkValidator $validator)
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
        $networks = $this->repository->with('users')->all();


        if (request()->wantsJson()) {

            return response()->json([
                'data' => $networks,
            ]);
        }

        return view('networks.index', compact('networks'));
    }

    public function create()
    {
        return view('networks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NetworkCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(NetworkCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $network = $this->repository->create($request->all());

            $response = [
                'message' => 'Rede cadastrada com sucesso',
                'data'    => $network->toArray(),
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
        $network = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $network,
            ]);
        }

        return view('networks.show', compact('network'));
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
        $network = $this->repository->find($id);

        return view('networks.edit', compact('network'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NetworkUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(NetworkUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $network = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Rede atualizada com sucesso.',
                'data'    => $network->toArray(),
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
                'message' => 'Network deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Network deleted.');
    }
}
