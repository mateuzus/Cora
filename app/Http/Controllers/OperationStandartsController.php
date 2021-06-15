<?php

namespace App\Http\Controllers;

use App\Entities\Network;
use App\Entities\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\OperationStandartCreateRequest;
use App\Http\Requests\OperationStandartUpdateRequest;
use App\Repositories\OperationStandartRepository;
use App\Validators\OperationStandartValidator;

/**
 * Class OperationStandartsController.
 *
 * @package namespace App\Http\Controllers;
 */
class OperationStandartsController extends Controller
{
    /**
     * @var OperationStandartRepository
     */
    protected $repository;

    /**
     * @var OperationStandartValidator
     */
    protected $validator;

    /**
     * OperationStandartsController constructor.
     *
     * @param OperationStandartRepository $repository
     * @param OperationStandartValidator $validator
     */
    public function __construct(OperationStandartRepository $repository, OperationStandartValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));



        if (request()->wantsJson()) {
            $user = User::find(\request()->user_id);
            if($user->isSuperAdmin()){
                $networks = Network::all();
            }else{
                $networks = $user->networks;
            }

            $operationStandart = $this->repository->with([
                'flow',
                'network',
                'roles','stores', 'departments'
            ])->findWhereIn('network_id', $networks->pluck('id')->toArray());
            return response()->json([
                'data' => $operationStandart,
            ]);
        }

        return view('operationstandart.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OperationStandartCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     *
     */
    public function store(OperationStandartCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            $data = $request->all();
            $operationStandart = $this->repository->create($data);
            if(isset($data['stores_id']) && $data['stores_id'] != "" && $data['stores_id'][0] != null){

                $operationStandart->stores()->sync($data['stores_id']);
            }
            if(isset($data['roles_id']) && $data['roles_id'] != "" && $data['roles_id'][0] != null){

                $operationStandart->roles()->sync($data['roles_id']);
            }
            if(isset($data['departments_id']) && $data['departments_id'] != "" && isset($data['departments_id'][0]) && $data['departments_id'][0] != null){
                $operationStandart->roles()->sync($data['departments_id']);
            }

            $response = [
                'message' => 'Pop cadastrado com sucesso.',
                'data'    => $operationStandart->toArray(),
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {
        $operationStandart = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $operationStandart,
            ]);
        }

        return view('operationstandart.show', compact('operationStandart'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $operationStandart = $this->repository->find($id);

        return view('operationstandart.edit', compact('operationStandart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OperationStandartUpdateRequest $request
     * @param string $id
     *
     * @return Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *
     */
    public function update(OperationStandartUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $data = $request->all();
            $operationStandart = $this->repository->update($request->all(), $id);
            if(isset($data['stores_id']) && $data['stores_id'] != "" && $data['stores_id'][0] != null){

                $operationStandart->stores()->sync($data['stores_id']);
            }
            if(isset($data['roles_id']) && $data['roles_id'] != "" && $data['roles_id'][0] != null){

                $operationStandart->roles()->sync($data['roles_id']);
            }
            if(isset($data['departments_id']) && $data['departments_id'] != "" && isset($data['departments_id'][0]) && $data['departments_id'][0] != null){
                $operationStandart->roles()->sync($data['departments_id']);
            }


            $response = [
                'message' => 'POP atualizado com sucesso.',
                'data'    => $operationStandart,
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
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'POP apagado com sucesso.',
//                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'OperationStandart deleted.');
    }
}
