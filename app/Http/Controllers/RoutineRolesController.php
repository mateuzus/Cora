<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RoutineRoleCreateRequest;
use App\Http\Requests\RoutineRoleUpdateRequest;
use App\Repositories\RoutineRoleRepository;
use App\Validators\RoutineRoleValidator;

/**
 * Class RoutineRolesController.
 *
 * @package namespace App\Http\Controllers;
 */
class RoutineRolesController extends Controller
{
    /**
     * @var RoutineRoleRepository
     */
    protected $repository;

    /**
     * @var RoutineRoleValidator
     */
    protected $validator;

    /**
     * RoutineRolesController constructor.
     *
     * @param RoutineRoleRepository $repository
     * @param RoutineRoleValidator $validator
     */
    public function __construct(RoutineRoleRepository $repository, RoutineRoleValidator $validator)
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
        $routineRoles = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $routineRoles,
            ]);
        }

        return view('routineRoles.index', compact('routineRoles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoutineRoleCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RoutineRoleCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $routineRole = $this->repository->create($request->all());

            $response = [
                'message' => 'RoutineRole created.',
                'data'    => $routineRole->toArray(),
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
        $routineRole = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $routineRole,
            ]);
        }

        return view('routineRoles.show', compact('routineRole'));
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
        $routineRole = $this->repository->find($id);

        return view('routineRoles.edit', compact('routineRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoutineRoleUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RoutineRoleUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $routineRole = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'RoutineRole updated.',
                'data'    => $routineRole->toArray(),
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
                'message' => 'RoutineRole deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'RoutineRole deleted.');
    }
}
