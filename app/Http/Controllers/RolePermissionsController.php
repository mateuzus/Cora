<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RolePermissionsCreateRequest;
use App\Http\Requests\RolePermissionsUpdateRequest;
use App\Repositories\RolePermissionsRepository;
use App\Validators\RolePermissionsValidator;

/**
 * Class RolePermissionsController.
 *
 * @package namespace App\Http\Controllers;
 */
class RolePermissionsController extends Controller
{
    /**
     * @var RolePermissionsRepository
     */
    protected $repository;

    /**
     * @var RolePermissionsValidator
     */
    protected $validator;

    /**
     * RolePermissionsController constructor.
     *
     * @param RolePermissionsRepository $repository
     * @param RolePermissionsValidator $validator
     */
    public function __construct(RolePermissionsRepository $repository, RolePermissionsValidator $validator)
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
        $rolePermissions = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $rolePermissions,
            ]);
        }

        return view('rolePermissions.index', compact('rolePermissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RolePermissionsCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RolePermissionsCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            foreach ($request->permission as $permission) {
                $rolePermission = $this->repository->create([
                    'role_id' => $request->role_id,
                    'permission_id' => $permission
                ]);

            }

            $response = [
                'message' => 'RolePermission created.',
                'data'    => $rolePermission->toArray(),
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
        $rolePermission = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $rolePermission,
            ]);
        }

        return view('rolePermissions.show', compact('rolePermission'));
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
        $rolePermission = $this->repository->find($id);

        return view('rolePermissions.edit', compact('rolePermission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RolePermissionUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RolesPermissionsUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $rolePermission = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'RolePermission updated.',
                'data'    => $rolePermission->toArray(),
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
                'message' => 'RolePermission deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'RolePermission deleted.');
    }
}
