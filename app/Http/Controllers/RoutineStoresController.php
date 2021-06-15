<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RoutineStoreCreateRequest;
use App\Http\Requests\RoutineStoreUpdateRequest;
use App\Repositories\RoutineStoreRepository;
use App\Validators\RoutineStoreValidator;

/**
 * Class RoutineStoresController.
 *
 * @package namespace App\Http\Controllers;
 */
class RoutineStoresController extends Controller
{
    /**
     * @var RoutineStoreRepository
     */
    protected $repository;

    /**
     * @var RoutineStoreValidator
     */
    protected $validator;

    /**
     * RoutineStoresController constructor.
     *
     * @param RoutineStoreRepository $repository
     * @param RoutineStoreValidator $validator
     */
    public function __construct(RoutineStoreRepository $repository, RoutineStoreValidator $validator)
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
        $routineStores = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $routineStores,
            ]);
        }

        return view('routineStores.index', compact('routineStores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoutineStoreCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RoutineStoreCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $routineStore = $this->repository->create($request->all());

            $response = [
                'message' => 'RoutineStore created.',
                'data'    => $routineStore->toArray(),
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
        $routineStore = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $routineStore,
            ]);
        }

        return view('routineStores.show', compact('routineStore'));
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
        $routineStore = $this->repository->find($id);

        return view('routineStores.edit', compact('routineStore'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoutineStoreUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RoutineStoreUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $routineStore = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'RoutineStore updated.',
                'data'    => $routineStore->toArray(),
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
                'message' => 'RoutineStore deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'RoutineStore deleted.');
    }
}
