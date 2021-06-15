<?php

namespace App\Http\Controllers;

use App\Entities\Routine;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\RoutineTaskCreateRequest;
use App\Http\Requests\RoutineTaskUpdateRequest;
use App\Repositories\RoutineTaskRepository;
use App\Validators\RoutineTaskValidator;

/**
 * Class RoutineTasksController.
 *
 * @package namespace App\Http\Controllers;
 */
class RoutineTasksController extends Controller
{
    /**
     * @var RoutineTaskRepository
     */
    protected $repository;

    /**
     * @var RoutineTaskValidator
     */
    protected $validator;

    /**
     * RoutineTasksController constructor.
     *
     * @param RoutineTaskRepository $repository
     * @param RoutineTaskValidator $validator
     */
    public function __construct(RoutineTaskRepository $repository, RoutineTaskValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $routine = Routine::find($request->routine);
        if (request()->wantsJson()) {

            $routineTasks = $this->repository->findWhere(['routine_id'=>$routine->id]);
            return response()->json([
                'data' => $routineTasks,
            ]);
        }

        return view('routinetasks.index', compact('routine'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoutineTaskCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(RoutineTaskCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $routineTask = $this->repository->create($request->all());

            $response = [
                'message' => 'Tarefa Adicionada com sucesso',
                'data'    => $routineTask->toArray(),
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
        $routineTask = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $routineTask,
            ]);
        }

        return view('routineTasks.show', compact('routineTask'));
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
        $routineTask = $this->repository->find($id);

        return view('routineTasks.edit', compact('routineTask'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoutineTaskUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(RoutineTaskUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $routineTask = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Tarefa atualizada com sucesso',
                'data'    => $routineTask->toArray(),
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
                'message' => 'Tarefa deletada com sucesso',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Tarefa deletada com sucesso');
    }
}
