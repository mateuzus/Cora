<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\OperationStandartTeamCreateRequest;
use App\Http\Requests\OperationStandartTeamUpdateRequest;
use App\Repositories\OperationStandartTeamRepository;
use App\Validators\OperationStandartTeamValidator;

/**
 * Class OperationStandartTeamsController.
 *
 * @package namespace App\Http\Controllers;
 */
class OperationStandartTeamsController extends Controller
{
    /**
     * @var OperationStandartTeamRepository
     */
    protected $repository;

    /**
     * @var OperationStandartTeamValidator
     */
    protected $validator;

    /**
     * OperationStandartTeamsController constructor.
     *
     * @param OperationStandartTeamRepository $repository
     * @param OperationStandartTeamValidator $validator
     */
    public function __construct(OperationStandartTeamRepository $repository, OperationStandartTeamValidator $validator)
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
        $operationStandartTeams = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $operationStandartTeams,
            ]);
        }

        return view('operationStandartTeams.index', compact('operationStandartTeams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OperationStandartTeamCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(OperationStandartTeamCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $operationStandartTeam = $this->repository->create($request->all());

            $response = [
                'message' => 'OperationStandartTeam created.',
                'data'    => $operationStandartTeam->toArray(),
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
        $operationStandartTeam = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $operationStandartTeam,
            ]);
        }

        return view('operationStandartTeams.show', compact('operationStandartTeam'));
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
        $operationStandartTeam = $this->repository->find($id);

        return view('operationStandartTeams.edit', compact('operationStandartTeam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OperationStandartTeamUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(OperationStandartTeamUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $operationStandartTeam = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'OperationStandartTeam updated.',
                'data'    => $operationStandartTeam->toArray(),
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
                'message' => 'OperationStandartTeam deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'OperationStandartTeam deleted.');
    }
}
