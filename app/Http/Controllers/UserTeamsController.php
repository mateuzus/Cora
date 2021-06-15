<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserTeamCreateRequest;
use App\Http\Requests\UserTeamUpdateRequest;
use App\Repositories\UserTeamRepository;
use App\Validators\UserTeamValidator;

/**
 * Class UserTeamsController.
 *
 * @package namespace App\Http\Controllers;
 */
class UserTeamsController extends Controller
{
    /**
     * @var UserTeamRepository
     */
    protected $repository;

    /**
     * @var UserTeamValidator
     */
    protected $validator;

    /**
     * UserTeamsController constructor.
     *
     * @param UserTeamRepository $repository
     * @param UserTeamValidator $validator
     */
    public function __construct(UserTeamRepository $repository, UserTeamValidator $validator)
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
        $userTeams = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $userTeams,
            ]);
        }

        return view('userTeams.index', compact('userTeams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserTeamCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(UserTeamCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $userTeam = $this->repository->create($request->all());

            $response = [
                'message' => 'UserTeam created.',
                'data'    => $userTeam->toArray(),
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
        $userTeam = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $userTeam,
            ]);
        }

        return view('userTeams.show', compact('userTeam'));
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
        $userTeam = $this->repository->find($id);

        return view('userTeams.edit', compact('userTeam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserTeamUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UserTeamUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $userTeam = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'UserTeam updated.',
                'data'    => $userTeam->toArray(),
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
                'message' => 'UserTeam deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'UserTeam deleted.');
    }
}
