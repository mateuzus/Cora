<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FlowRolesCreateRequest;
use App\Http\Requests\FlowRolesUpdateRequest;
use App\Repositories\FlowRolesRepository;
use App\Validators\FlowRolesValidator;

/**
 * Class FlowRolesController.
 *
 * @package namespace App\Http\Controllers;
 */
class FlowRolesController extends Controller
{
    /**
     * @var FlowRolesRepository
     */
    protected $repository;

    /**
     * @var FlowRolesValidator
     */
    protected $validator;

    /**
     * FlowRolesController constructor.
     *
     * @param FlowRolesRepository $repository
     * @param FlowRolesValidator $validator
     */
    public function __construct(FlowRolesRepository $repository, FlowRolesValidator $validator)
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
        $flowRoles = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flowRoles,
            ]);
        }

        return view('flowRoles.index', compact('flowRoles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FlowRolesCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(FlowRolesCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $flowRole = $this->repository->create($request->all());

            $response = [
                'message' => 'FlowRoles created.',
                'data'    => $flowRole->toArray(),
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
        $flowRole = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flowRole,
            ]);
        }

        return view('flowRoles.show', compact('flowRole'));
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
        $flowRole = $this->repository->find($id);

        return view('flowRoles.edit', compact('flowRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FlowRolesUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(FlowRolesUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $flowRole = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'FlowRoles updated.',
                'data'    => $flowRole->toArray(),
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
                'message' => 'FlowRoles deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'FlowRoles deleted.');
    }
}
