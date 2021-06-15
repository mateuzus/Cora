<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\OperationStandartStoresCreateRequest;
use App\Http\Requests\OperationStandartStoresUpdateRequest;
use App\Repositories\OperationStandartStoresRepository;
use App\Validators\OperationStandartStoresValidator;

/**
 * Class OperationStandartStoresController.
 *
 * @package namespace App\Http\Controllers;
 */
class OperationStandartStoresController extends Controller
{
    /**
     * @var OperationStandartStoresRepository
     */
    protected $repository;

    /**
     * @var OperationStandartStoresValidator
     */
    protected $validator;

    /**
     * OperationStandartStoresController constructor.
     *
     * @param OperationStandartStoresRepository $repository
     * @param OperationStandartStoresValidator $validator
     */
    public function __construct(OperationStandartStoresRepository $repository, OperationStandartStoresValidator $validator)
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
        $operationStandartStores = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $operationStandartStores,
            ]);
        }

        return view('operationStandartStores.index', compact('operationStandartStores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OperationStandartStoresCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(OperationStandartStoresCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $operationStandartStore = $this->repository->create($request->all());

            $response = [
                'message' => 'OperationStandartStores created.',
                'data'    => $operationStandartStore->toArray(),
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
        $operationStandartStore = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $operationStandartStore,
            ]);
        }

        return view('operationStandartStores.show', compact('operationStandartStore'));
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
        $operationStandartStore = $this->repository->find($id);

        return view('operationStandartStores.edit', compact('operationStandartStore'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OperationStandartStoresUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(OperationStandartStoresUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $operationStandartStore = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'OperationStandartStores updated.',
                'data'    => $operationStandartStore->toArray(),
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
                'message' => 'OperationStandartStores deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'OperationStandartStores deleted.');
    }
}
