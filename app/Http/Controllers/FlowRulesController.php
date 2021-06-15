<?php

namespace App\Http\Controllers;

use App\Entities\Flow;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FlowRulesCreateRequest;
use App\Http\Requests\FlowRulesUpdateRequest;
use App\Repositories\FlowRulesRepository;
use App\Validators\FlowRulesValidator;

/**
 * Class FlowRulesController.
 *
 * @package namespace App\Http\Controllers;
 */
class FlowRulesController extends Controller
{
    /**
     * @var FlowRulesRepository
     */
    protected $repository;

    /**
     * @var FlowRulesValidator
     */
    protected $validator;

    /**
     * FlowRulesController constructor.
     *
     * @param FlowRulesRepository $repository
     * @param FlowRulesValidator $validator
     */
    public function __construct(FlowRulesRepository $repository, FlowRulesValidator $validator)
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
        $flow = Flow::find(\request()->flow_id);
        $flowRules = $this->repository->with([
            'flow',
            'department',
            'store',
            'role',
            'team',
            'flow.network.config',
        ])->findWhere(['flow_id'=>$flow->id]);

        $flowRules->map(function ($rule){
           $rule->user = $rule->users();
        });


        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flowRules,
            ]);
        }

        return view('flow_rules.index', compact('flow','flowRules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FlowRulesCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(FlowRulesCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $flowRule = $this->repository->create($request->all());

            $response = [
                'message' => 'FlowRules created.',
                'data'    => $flowRule->toArray(),
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
        $flowRule = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flowRule,
            ]);
        }

        return view('flowRules.show', compact('flowRule'));
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
        $flowRule = $this->repository->find($id);

        return view('flowRules.edit', compact('flowRule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FlowRulesUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(FlowRulesUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $flowRule = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'FlowRules updated.',
                'data'    => $flowRule->toArray(),
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
                'message' => 'FlowRules deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'FlowRules deleted.');
    }
}
