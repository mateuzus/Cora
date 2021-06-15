<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RoutineDepartmentCreateRequest;
use App\Http\Requests\RoutineDepartmentUpdateRequest;
use App\Repositories\RoutineDepartmentRepository;
use App\Validators\RoutineDepartmentValidator;

/**
 * Class RoutineDepartmentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class RoutineDepartmentsController extends Controller
{
    /**
     * @var RoutineDepartmentRepository
     */
    protected $repository;

    /**
     * @var RoutineDepartmentValidator
     */
    protected $validator;

    /**
     * RoutineDepartmentsController constructor.
     *
     * @param RoutineDepartmentRepository $repository
     * @param RoutineDepartmentValidator $validator
     */
    public function __construct(RoutineDepartmentRepository $repository, RoutineDepartmentValidator $validator)
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
        $routineDepartments = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $routineDepartments,
            ]);
        }

        return view('routineDepartments.index', compact('routineDepartments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoutineDepartmentCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RoutineDepartmentCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $routineDepartment = $this->repository->create($request->all());

            $response = [
                'message' => 'RoutineDepartment created.',
                'data'    => $routineDepartment->toArray(),
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
        $routineDepartment = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $routineDepartment,
            ]);
        }

        return view('routineDepartments.show', compact('routineDepartment'));
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
        $routineDepartment = $this->repository->find($id);

        return view('routineDepartments.edit', compact('routineDepartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoutineDepartmentUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RoutineDepartmentUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $routineDepartment = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'RoutineDepartment updated.',
                'data'    => $routineDepartment->toArray(),
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
                'message' => 'RoutineDepartment deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'RoutineDepartment deleted.');
    }
}
