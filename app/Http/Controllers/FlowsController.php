<?php

namespace App\Http\Controllers;

use App\Entities\Flow;
use App\Entities\Network;
use App\Entities\Role;
use App\Entities\Store;
use App\Services\Workflow\DefaultBehaviorRegistry;
use App\Services\Workflow\ProcessBuilder;
use App\Services\Workflow\ProcessEngine;
use App\Services\Workflow\Token;
use App\Services\Workflow\Visual\BuildDigraphScript;
use App\Services\Workflow\Visual\VisualizeFlow;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FlowCreateRequest;
use App\Http\Requests\FlowUpdateRequest;
use App\Repositories\FlowRepository;
use App\Validators\FlowValidator;
use function App\Services\WorkflowValues\get_values;

/**
 * Class FlowsController.
 *
 * @package namespace App\Http\Controllers;
 */
class FlowsController extends Controller
{
    /**
     * @var FlowRepository
     */
    protected $repository;

    /**
     * @var FlowValidator
     */
    protected $validator;


    protected $flow;
    /**
     * FlowsController constructor.
     *
     * @param FlowRepository $repository
     * @param FlowValidator $validator
     * @param Flow $flow
     */
    public function __construct(FlowRepository $repository, FlowValidator $validator, Flow $flow)
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
        $flows = $this->repository->with("fontData")->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flows,
            ]);
        }

        return view('flows.index', compact('flows'));
    }
    public function create()
    {
        if(Auth::user()->isSuperAdmin()){
            $networks = Network::all()->pluck('description', 'id');
        }else{
            $networks = Network::whereIn('id', Auth::user()->network->pluck('id'))->pluck('description', 'id');
        }
        return view('flows.create', compact('networks'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  FlowCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(FlowCreateRequest $request)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $flow = $this->repository->create($request->all());

              $response = [
                  'message' => 'Fluxo cadastrado com sucesso.',
                  'data'    => $flow->toArray(),
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
        $flow = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $flow,
            ]);
        }

        $process = (new ProcessBuilder())
            ->createNode($flow->description)->end()
            ->createStartTransition($flow->description)->end()
        ;

        $child = $flow;
        $process = $this->recusiveFlow($child, $process);
        $process = $process->getProcess();
        $graph = (new VisualizeFlow())->createGraph($process);
        $graph->setAttribute('graphviz.graph.ranksep', 0.1);
        $graph->setAttribute('alom.graphviz', array_replace($graph->getAttribute('alom.graphviz'), [
            'ranksep' => 0.2,
        ]));
        $pvmContext = json_encode([
            'process' => get_values($process),
            'tokens' => [],
            'dot' => (new BuildDigraphScript())->build($graph)
        ]);

        return view('flows.show', compact('flow', 'pvmContext'));
    }


    public function recusiveFlow($flow, $process){
        foreach ($flow->children() as $child){
            $process->createNode($child->description);
            $process->createTransition($flow->description, $child->description)->end();
        }
        return $process;
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
        $flow = $this->repository->find($id);
        $networks = Network::all()->pluck('description', 'id');
        return view('flows.edit', compact('flow','networks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FlowUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(FlowUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $flow = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Fluxo atualizado',
                'data'    => $flow->toArray(),
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
                'message' => 'Flow deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Flow deleted.');
    }
}
