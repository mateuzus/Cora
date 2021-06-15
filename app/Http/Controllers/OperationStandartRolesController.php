<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\OperationStandartRolesCreateRequest;
use App\Http\Requests\OperationStandartRolesUpdateRequest;
use App\Repositories\OperationStandartRolesRepository;
use App\Validators\OperationStandartRolesValidator;

/**
 * Class OperationStandartRolesController.
 *
 * @package namespace App\Http\Controllers;
 */
class OperationStandartRolesController extends Controller
{
    /**
     * @var OperationStandartRolesRepository
     */
    protected $repository;

    /**
     * @var OperationStandartRolesValidator
     */
    protected $validator;

    /**
     * OperationStandartRolesController constructor.
     *
     * @param OperationStandartRolesRepository $repository
     * @param OperationStandartRolesValidator $validator
     */
    public function __construct(OperationStandartRolesRepository $repository, OperationStandartRolesValidator $validator)
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
        $operationStandartRoles = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $operationStandartRoles,
            ]);
        }

        return view('operationStandartRoles.index', compact('operationStandartRoles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OperationStandartRolesCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(OperationStandartRolesCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $operationStandartRole = $this->repository->create($request->all());

            $response = [
                'message' => 'OperationStandartRoles created.',
                'data'    => $operationStandartRole->toArray(),
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
        $operationStandartRole = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $operationStandartRole,
            ]);
        }

        return view('operationStandartRoles.show', compact('operationStandartRole'));
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
        $operationStandartRole = $this->repository->find($id);

        return view('operationStandartRoles.edit', compact('operationStandartRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OperationStandartRolesUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(OperationStandartRolesUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $operationStandartRole = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'OperationStandartRoles updated.',
                'data'    => $operationStandartRole->toArray(),
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
                'message' => 'OperationStandartRoles deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'OperationStandartRoles deleted.');
    }
}
