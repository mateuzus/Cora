<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RoleUserCreateRequest;
use App\Http\Requests\RoleUserUpdateRequest;
use App\Repositories\RoleUserRepository;
use App\Validators\RoleUserValidator;

/**
 * Class RoleUsersController.
 *
 * @package namespace App\Http\Controllers;
 */
class RoleUsersController extends Controller
{
    /**
     * @var RoleUserRepository
     */
    protected $repository;

    /**
     * @var RoleUserValidator
     */
    protected $validator;

    /**
     * RoleUsersController constructor.
     *
     * @param RoleUserRepository $repository
     * @param RoleUserValidator $validator
     */
    public function __construct(RoleUserRepository $repository, RoleUserValidator $validator)
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
        $roleUsers = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $roleUsers,
            ]);
        }

        return view('roleUsers.index', compact('roleUsers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleUserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RoleUserCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $roleUser = $this->repository->create($request->all());

            $response = [
                'message' => 'RoleUser created.',
                'data'    => $roleUser->toArray(),
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
        $roleUser = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $roleUser,
            ]);
        }

        return view('roleUsers.show', compact('roleUser'));
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
        $roleUser = $this->repository->find($id);

        return view('roleUsers.edit', compact('roleUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleUserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RoleUserUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $roleUser = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'RoleUser updated.',
                'data'    => $roleUser->toArray(),
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
                'message' => 'RoleUser deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'RoleUser deleted.');
    }
}
