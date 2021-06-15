<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserDepartmentCreateRequest;
use App\Http\Requests\UserDepartmentUpdateRequest;
use App\Repositories\UserDepartmentRepository;
use App\Validators\UserDepartmentValidator;

/**
 * Class UserDepartmentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class UserDepartmentsController extends Controller
{
    /**
     * @var UserDepartmentRepository
     */
    protected $repository;

    /**
     * @var UserDepartmentValidator
     */
    protected $validator;

    /**
     * UserDepartmentsController constructor.
     *
     * @param UserDepartmentRepository $repository
     * @param UserDepartmentValidator $validator
     */
    public function __construct(UserDepartmentRepository $repository, UserDepartmentValidator $validator)
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
        $userDepartments = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $userDepartments,
            ]);
        }

        return view('userDepartments.index', compact('userDepartments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserDepartmentCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(UserDepartmentCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $userDepartment = $this->repository->create($request->all());

            $response = [
                'message' => 'UserDepartment created.',
                'data'    => $userDepartment->toArray(),
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
        $userDepartment = $this->repository->find($id);
        dd($userDepartment);
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $userDepartment,
            ]);
        }

        return view('userDepartments.show', compact('userDepartment'));
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
        $userDepartment = $this->repository->find($id);

        return view('userDepartments.edit', compact('userDepartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserDepartmentUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UserDepartmentUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $userDepartment = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'UserDepartment updated.',
                'data'    => $userDepartment->toArray(),
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
                'message' => 'UserDepartment deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'UserDepartment deleted.');
    }
}
