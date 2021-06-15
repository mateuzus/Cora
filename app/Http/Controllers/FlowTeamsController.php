<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FlowTeamCreateRequest;
use App\Http\Requests\FlowTeamUpdateRequest;
use App\Repositories\FlowTeamRepository;
use App\Validators\FlowTeamValidator;

/**
 * Class FlowTeamsController.
 *
 * @package namespace App\Http\Controllers;
 */
class FlowTeamsController extends Controller
{
    /**
     * @var FlowTeamRepository
     */
    protected $repository;

    /**
     * @var FlowTeamValidator
     */
    protected $validator;

    /**
     * FlowTeamsController constructor.
     *
     * @param FlowTeamRepository $repository
     * @param FlowTeamValidator $validator
     */
    public function __construct(FlowTeamRepository $repository, FlowTeamValidator $validator)
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
        $flowTeams = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flowTeams,
            ]);
        }

        return view('flowTeams.index', compact('flowTeams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FlowTeamCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(FlowTeamCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $flowTeam = $this->repository->create($request->all());

            $response = [
                'message' => 'FlowTeam created.',
                'data'    => $flowTeam->toArray(),
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
        $flowTeam = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flowTeam,
            ]);
        }

        return view('flowTeams.show', compact('flowTeam'));
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
        $flowTeam = $this->repository->find($id);

        return view('flowTeams.edit', compact('flowTeam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FlowTeamUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(FlowTeamUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $flowTeam = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'FlowTeam updated.',
                'data'    => $flowTeam->toArray(),
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
                'message' => 'FlowTeam deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'FlowTeam deleted.');
    }
}
