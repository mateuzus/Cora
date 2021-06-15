<?php

namespace App\Http\Controllers;

use App\Entities\Network;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\DepartmentCreateRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Repositories\DepartmentRepository;
use App\Validators\DepartmentValidator;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class DepartmentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class DepartmentsController extends Controller
{
    /**
     * @var DepartmentRepository
     */
    protected $repository;

    /**
     * @var DepartmentValidator
     */
    protected $validator;

    /**
     * DepartmentsController constructor.
     *
     * @param DepartmentRepository $repository
     * @param DepartmentValidator $validator
     */
    public function __construct(DepartmentRepository $repository, DepartmentValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|JsonResponse
     */
    public function index()
    {
        $this->repository->pushCriteria(app(RequestCriteria::class));
        $departments = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $departments,
            ]);
        }

        return view('departments.index', compact('departments'));
    }
    public function create(){
        if(Auth::user()->isSuperAdmin()){
            $networks = Network::all()->pluck('description', 'id');
        }else{
            $networks = Network::whereIn('id', Auth::user()->networks->pluck('id'))->pluck('description', 'id');
        }
        return view('departments.create', compact('networks'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  DepartmentCreateRequest $request
     *
     * @return JsonResponse|RedirectResponse|Response
     *
     */
    public function store(DepartmentCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $department = $this->repository->create($request->all());

            $response = [
                'message' => 'Mercadológico cadastrado com sucesso.',
                'data'    => $department->toArray(),
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
     * @param int $id
     *
     * @return Application|Factory|JsonResponse|Response|View
     */
    public function show(int $id)
    {
        $departments = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $departments,
            ]);
        }

        return view('departments.show', compact('departments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Application|Factory|Response|View
     */
    public function edit(int $id)
    {
        $departments = $this->repository->find($id);
        $networks = Network::all()->pluck('description', 'id');
        return view('departments.edit', compact('departments','networks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DepartmentUpdateRequest $request
     * @param string $id
     *
     * @return Response|JsonResponse|RedirectResponse
     *
     */
    public function update(DepartmentUpdateRequest $request, string $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $department = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Departamento atualizado.',
                'data'    => $department->toArray(),
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
     * @param int $id
     *
     * @return JsonResponse|RedirectResponse|Response
     */
    public function destroy(int $id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Department deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Department deleted.');
    }
}
