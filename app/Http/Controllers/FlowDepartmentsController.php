<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FlowDepartmentsCreateRequest;
use App\Http\Requests\FlowDepartmentsUpdateRequest;
use App\Repositories\FlowDepartmentsRepository;
use App\Validators\FlowDepartmentsValidator;

/**
 * Class FlowDepartmentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class FlowDepartmentsController extends Controller
{
    /**
     * @var FlowDepartmentsRepository
     */
    protected $repository;

    /**
     * @var FlowDepartmentsValidator
     */
    protected $validator;

    /**
     * FlowDepartmentsController constructor.
     *
     * @param FlowDepartmentsRepository $repository
     * @param FlowDepartmentsValidator $validator
     */
    public function __construct(FlowDepartmentsRepository $repository, FlowDepartmentsValidator $validator)
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
        $flowDepartments = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flowDepartments,
            ]);
        }

        return view('flowDepartments.index', compact('flowDepartments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FlowDepartmentsCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(FlowDepartmentsCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $flowDepartment = $this->repository->create($request->all());

            $response = [
                'message' => 'FlowDepartments created.',
                'data'    => $flowDepartment->toArray(),
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
        $flowDepartment = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flowDepartment,
            ]);
        }

        return view('flowDepartments.show', compact('flowDepartment'));
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
        $flowDepartment = $this->repository->find($id);

        return view('flowDepartments.edit', compact('flowDepartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FlowDepartmentsUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(FlowDepartmentsUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $flowDepartment = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'FlowDepartments updated.',
                'data'    => $flowDepartment->toArray(),
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
                'message' => 'FlowDepartments deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'FlowDepartments deleted.');
    }
}
