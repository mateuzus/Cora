<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RoutineCreateRequest;
use App\Http\Requests\RoutineUpdateRequest;
use App\Repositories\RoutineRepository;
use App\Validators\RoutineValidator;

/**
 * Class RoutinesController.
 *
 * @package namespace App\Http\Controllers;
 */
class RoutinesController extends Controller
{
    /**
     * @var RoutineRepository
     */
    protected $repository;

    /**
     * @var RoutineValidator
     */
    protected $validator;

    /**
     * RoutinesController constructor.
     *
     * @param RoutineRepository $repository
     * @param RoutineValidator $validator
     */
    public function __construct(RoutineRepository $repository, RoutineValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));


        if (request()->wantsJson()) {
            $routines = $this->repository->with([
                'roles','stores', 'departments', 'tasks'
            ])->all();
            return response()->json([
                'data' => $routines,
            ]);
        }

        return view('routines.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoutineCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RoutineCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $data = $request->all();
            $routine = $this->repository->create($data);

            if(isset($data['stores_id']) && $data['stores_id'] != "" && $data['stores_id'][0] != null){

                $routine->stores()->sync($data['stores_id']);
            }
            if(isset($data['roles_id']) && $data['roles_id'] != "" && $data['roles_id'][0] != null){

                $routine->roles()->sync($data['roles_id']);
            }
            if(isset($data['departments_id']) && $data['departments_id'] != "" && isset($data['departments_id'][0]) && $data['departments_id'][0] != null){
                $routine->roles()->sync($data['departments_id']);
            }
            $response = [
                'message' => 'Rotina cadastrada com sucesso',
                'data'    => $routine->toArray(),
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
        $routine = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $routine,
            ]);
        }

        return view('routines.show', compact('routine'));
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
        $routine = $this->repository->find($id);

        return view('routines.edit', compact('routine'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoutineUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RoutineUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $data = $request->all();
            $routine = $this->repository->update($data, $id);
            if(isset($data['stores_id']) && $data['stores_id'] != "" && $data['stores_id'][0] != null){

                $routine->stores()->sync($data['stores_id']);
            }
            if(isset($data['roles_id']) && $data['roles_id'] != "" && $data['roles_id'][0] != null){

                $routine->roles()->sync($data['roles_id']);
            }

            if(isset($data['departments_id']) && $data['departments_id'] != "" && isset($data['departments_id'][0]) && $data['departments_id'][0] != null){
                $routine->roles()->sync($data['departments_id']);
            }
            $response = [
                'message' => 'Rotina atualizada',
                'data'    => $routine->toArray(),
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
                'message' => 'Rotina Apagada',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Rotina Apagada');
    }
}
