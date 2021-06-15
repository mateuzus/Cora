<?php

namespace App\Http\Controllers;

use App\Entities\OperationStandart;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\OperationStandartTaskCreateRequest;
use App\Http\Requests\OperationStandartTaskUpdateRequest;
use App\Repositories\OperationStandartTaskRepository;
use App\Validators\OperationStandartTaskValidator;

/**
 * Class OperationStandartTasksController.
 *
 * @package namespace App\Http\Controllers;
 */
class OperationStandartTasksController extends Controller
{
    /**
     * @var OperationStandartTaskRepository
     */
    protected $repository;

    /**
     * @var OperationStandartTaskValidator
     */
    protected $validator;

    /**
     * OperationStandartTasksController constructor.
     *
     * @param OperationStandartTaskRepository $repository
     * @param OperationStandartTaskValidator $validator
     */
    public function __construct(OperationStandartTaskRepository $repository, OperationStandartTaskValidator $validator)
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
        $pop = OperationStandart::find( $request->pop);
        if (request()->wantsJson()) {

            $operationStandartTasks = $this->repository->findWhere(['pop_id'=> $pop->id]);
            return response()->json([
                'data' => $operationStandartTasks,
            ]);
        }
        return view('operationstandarttasks.index', compact( 'pop'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OperationStandartTaskCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(OperationStandartTaskCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $operationStandartTask = $this->repository->create($request->all());

            $response = [
                'message' => 'Tarefa adicionada.',
                'data'    => $operationStandartTask->toArray(),
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
        $operationStandartTask = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $operationStandartTask,
            ]);
        }

        return view('operationstandarttasks.show', compact('operationStandartTask'));
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
        $operationStandartTask = $this->repository->find($id);

        return view('operationstandarttasks.edit', compact('operationStandartTask'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  OperationStandartTaskUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(OperationStandartTaskUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $operationStandartTask = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Tarefa Atualiada com sucesso.',
                'data'    => $operationStandartTask->toArray(),
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
                'message' => 'OperationStandartTask deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'OperationStandartTask deleted.');
    }
}
