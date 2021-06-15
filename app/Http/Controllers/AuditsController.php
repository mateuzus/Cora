<?php



namespace App\Http\Controllers;

use App\Entities\Network;
use App\Http\Requests\AuditCreateRequest;
use App\Http\Requests\AuditUpdateRequest;
use App\Http\Requests\DepartmentCreateRequest;
use App\Repositories\AuditRepository;
use App\Validators\AuditValidator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class AuditsController extends Controller
{
    /**
     * @var AuditRepository
     */
    protected $repository;

    /**
     * AuditsController constructor.
     * @var AuditValidator
     */
    protected $validator;

    /**
     * AuditsController constructor.
     * @param AuditRepository $repository
     * @param AuditValidator $validator
     */

    public function __construct(AuditRepository $repository, AuditValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function index()
    {

        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $audits = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $audits,
            ]);
        }
        return view('audits.index', compact('audits'));
    }


    public function create(){
        if(Auth::user()->isSuperAdmin()){
            $networks = Network::all()->pluck('description', 'id');
        }else{
            $networks = Network::whereIn('id', Auth::user()->network->pluck('id'))->pluck('description', 'id');
        }
        return view('audits.create', compact('networks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AuditCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     *
     */

    public function store(AuditCreateRequest $request)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $audits = $this->repository->create($request->all());

            $response = [
                'message' => 'Auditoria criada com sucesso',
                'data' => $audits->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }
            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }
            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $audits = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $audits,
            ]);
        }

        return view('audits.show', compact('audits'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param AuditUpdateRequest $requests
     * @param string $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     *
     */

    public function update(AuditUpdateRequest $request, $id)
    {
        try{
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $audits = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Listing updated.',
                'data'    => $audits->toArray(),
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
                'message' => 'Audits deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Listing deleted.');
    }

}
