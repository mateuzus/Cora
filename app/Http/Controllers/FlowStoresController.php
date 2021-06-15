<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FlowStoresCreateRequest;
use App\Http\Requests\FlowStoresUpdateRequest;
use App\Repositories\FlowStoresRepository;
use App\Validators\FlowStoresValidator;

/**
 * Class FlowStoresController.
 *
 * @package namespace App\Http\Controllers;
 */
class FlowStoresController extends Controller
{
    /**
     * @var FlowStoresRepository
     */
    protected $repository;

    /**
     * @var FlowStoresValidator
     */
    protected $validator;

    /**
     * FlowStoresController constructor.
     *
     * @param FlowStoresRepository $repository
     * @param FlowStoresValidator $validator
     */
    public function __construct(FlowStoresRepository $repository, FlowStoresValidator $validator)
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
        $flowStores = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flowStores,
            ]);
        }

        return view('flowStores.index', compact('flowStores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FlowStoresCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(FlowStoresCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $flowStore = $this->repository->create($request->all());

            $response = [
                'message' => 'FlowStores created.',
                'data'    => $flowStore->toArray(),
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
        $flowStore = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flowStore,
            ]);
        }

        return view('flowStores.show', compact('flowStore'));
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
        $flowStore = $this->repository->find($id);

        return view('flowStores.edit', compact('flowStore'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FlowStoresUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(FlowStoresUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $flowStore = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'FlowStores updated.',
                'data'    => $flowStore->toArray(),
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
                'message' => 'FlowStores deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'FlowStores deleted.');
    }
}
