<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RoutineTeamCreateRequest;
use App\Http\Requests\RoutineTeamUpdateRequest;
use App\Repositories\RoutineTeamRepository;
use App\Validators\RoutineTeamValidator;

/**
 * Class RoutineTeamsController.
 *
 * @package namespace App\Http\Controllers;
 */
class RoutineTeamsController extends Controller
{
    /**
     * @var RoutineTeamRepository
     */
    protected $repository;

    /**
     * @var RoutineTeamValidator
     */
    protected $validator;

    /**
     * RoutineTeamsController constructor.
     *
     * @param RoutineTeamRepository $repository
     * @param RoutineTeamValidator $validator
     */
    public function __construct(RoutineTeamRepository $repository, RoutineTeamValidator $validator)
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
        $routineTeams = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $routineTeams,
            ]);
        }

        return view('routineTeams.index', compact('routineTeams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoutineTeamCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RoutineTeamCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $routineTeam = $this->repository->create($request->all());

            $response = [
                'message' => 'RoutineTeam created.',
                'data'    => $routineTeam->toArray(),
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
        $routineTeam = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $routineTeam,
            ]);
        }

        return view('routineTeams.show', compact('routineTeam'));
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
        $routineTeam = $this->repository->find($id);

        return view('routineTeams.edit', compact('routineTeam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoutineTeamUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RoutineTeamUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $routineTeam = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'RoutineTeam updated.',
                'data'    => $routineTeam->toArray(),
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
                'message' => 'RoutineTeam deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'RoutineTeam deleted.');
    }
}
