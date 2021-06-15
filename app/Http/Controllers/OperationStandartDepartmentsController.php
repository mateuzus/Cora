<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\OperationStandartDepartmentCreateRequest;
use App\Http\Requests\OperationStandartDepartmentUpdateRequest;
use App\Repositories\OperationStandartDepartmentRepository;
use App\Validators\OperationStandartDepartmentValidator;

/**
 * Class OperationStandartDepartmentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class OperationStandartDepartmentsController extends Controller
{
    /**
     * @var OperationStandartDepartmentRepository
     */
    protected $repository;

    /**
     * @var OperationStandartDepartmentValidator
     */
    protected $validator;

    /**
     * OperationStandartDepartmentsController constructor.
     *
     * @param OperationStandartDepartmentRepository $repository
     * @param OperationStandartDepartmentValidator $validator
     */
    public function __construct(OperationStandartDepartmentRepository $repository, OperationStandartDepartmentValidator $validator)
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
        $operationStandartDepartments = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $operationStandartDepartments,
            ]);
        }

        return view('operationStandartDepartments.index', compact('operationStandartDepartments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OperationStandartDepartmentCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(OperationStandartDepartmentCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $operationStandartDepartment = $this->repository->create($request->all());

            $response = [
                'message' => 'OperationStandartDepartment created.',
                'data'    => $operationStandartDepartment->toArray(),
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
        $operationStandartDepartment = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $operationStandartDepartment,
            ]);
        }

        return view('operationStandartDepartments.show', compact('operationStandartDepartment'));
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
        $operationStandartDepartment = $this->repository->find($id);

        return view('operationStandartDepartments.edit', compact('operationStandartDepartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OperationStandartDepartmentUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(OperationStandartDepartmentUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $operationStandartDepartment = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'OperationStandartDepartment updated.',
                'data'    => $operationStandartDepartment->toArray(),
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
                'message' => 'OperationStandartDepartment deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'OperationStandartDepartment deleted.');
    }
}
