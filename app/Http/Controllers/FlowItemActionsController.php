<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FlowItemActionsCreateRequest;
use App\Http\Requests\FlowItemActionsUpdateRequest;
use App\Repositories\FlowItemActionsRepository;
use App\Validators\FlowItemActionsValidator;

/**
 * Class FlowItemActionsController.
 *
 * @package namespace App\Http\Controllers;
 */
class FlowItemActionsController extends Controller
{
    /**
     * @var FlowItemActionsRepository
     */
    protected $repository;

    /**
     * @var FlowItemActionsValidator
     */
    protected $validator;

    /**
     * FlowItemActionsController constructor.
     *
     * @param FlowItemActionsRepository $repository
     * @param FlowItemActionsValidator $validator
     */
    public function __construct(FlowItemActionsRepository $repository, FlowItemActionsValidator $validator)
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
        $flowItemActions = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flowItemActions,
            ]);
        }

        return view('flowItemActions.index', compact('flowItemActions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FlowItemActionsCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(FlowItemActionsCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $flowItemAction = $this->repository->create($request->all());

            $response = [
                'message' => 'FlowItemActions created.',
                'data'    => $flowItemAction->toArray(),
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
        $flowItemAction = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flowItemAction,
            ]);
        }

        return view('flowItemActions.show', compact('flowItemAction'));
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
        $flowItemAction = $this->repository->find($id);

        return view('flowItemActions.edit', compact('flowItemAction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FlowItemActionsUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(FlowItemActionsUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $flowItemAction = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'FlowItemActions updated.',
                'data'    => $flowItemAction->toArray(),
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
                'message' => 'FlowItemActions deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'FlowItemActions deleted.');
    }
}
