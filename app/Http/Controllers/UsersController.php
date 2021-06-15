<?php

namespace App\Http\Controllers;

use App\Entities\Department;
use App\Entities\Network;
use App\Entities\Operator;
use App\Entities\Role;
use App\Entities\Store;
use App\Entities\Team;
use App\Entities\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Repositories\UserRepository;
use App\Validators\UserValidator;

/**
 * Class UsersController.
 *
 * @package namespace App\Http\Controllers;
 */
class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    protected $validator;

    /**
     * UsersController constructor.
     *
     * @param UserRepository $repository
     * @param UserValidator $validator
     */
    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        if(Auth::user()->isSuperAdmin()){
            $users = $this->repository->all();
        }elseif(Auth::user()->isManagerNetwork()){
            $networks = Auth::user()->networks->pluck('id');

            $users = User::whereHas('networks', function ($query) use($networks){
                return $query->whereIn("network_id", $networks->toArray());
            })->get();
        }


        if (request()->wantsJson()) {

            return response()->json([
                'data' => $users,
            ]);
        }

        return view('users.index', compact('users'));
    }


    public function create(){

        if(Auth::user()->isSuperAdmin()){
            $networks = Network::all()->pluck('description', 'id');
            $roles = Role::all()->pluck("name", "id");
            $stores = Store::all()->pluck("name", 'id');
            $departments = Department::all()->pluck("name", "id");
            $teams = Team::all()->pluck("name", "id");

        }elseif(Auth::user()->isAdminRede()){
            $redes = Auth::user()->networks->pluck('id');

            $networks = Network::whereIn('id',$redes->toArray() )->pluck('description', 'id');
            $roles = Role::where('id','!=', 1)->get()->pluck("name", "id");
            $stores = Store::whereIn('network_id', $redes->toArray())->pluck("name", 'id');
            $departments = Department::whereIn('network_id', $redes->toArray())->pluck("name", "id");
            $teams = Team::whereIn('network_id', $redes->toArray())->pluck("name", "id");
        }else{
            $networks = Auth::user()->networks->pluck('id');
            $roles = Auth::user()->roles->pluck('id');
            $stores = Auth::user()->stores->pluck('id');
            $departments = Auth::user()->departments->pluck('id');
            $teams = Auth::user()->teams->pluck('id');

            $networks = Network::whereIn('id',$networks->toArray())->pluck('description', 'id');
            $roles = Role::whereIn('id',$roles->toArray())->get()->pluck("name", "id");
            $stores = Store::whereIn('network_id', $networks->toArray())->pluck("name", 'id');
            $departments = Department::whereIn('network_id', $networks->toArray())->pluck("name", "id");
            $teams = Team::whereIn('network_id', $networks->toArray())->pluck("name", "id");
        }

        return view("users.create", compact('networks', 'roles', 'stores', 'departments', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(UserCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $data = $request->all();

            if($data['password'] == "" || is_null($data['password'])){
                unset($data['password']);
            }else{
                $data['password'] = bcrypt($data['password']);
            }
            $user = $this->repository->create($data);

            if(isset($data['network_id']) && $data['network_id'] != ""){
                $user->networks()->sync($data['network_id']);
            }

            if(isset($data['role_id']) && $data['role_id'] != ""){
                $user->roles()->sync($data['role_id']);
            }

            if(isset($data['store_id']) && $data['store_id'] != ""){
                $user->stores()->sync($data['store_id']);
            }

            if(isset($data['department_id']) && $data['department_id'] != ""){
                $user->departments()->sync($data['department_id']);
            }

            if(isset($data['team_id']) && $data['team_id'] != ""){
                $user->teams()->sync($data['team_id']);
            }



            $response = [
                'message' => 'Usuário Cadastrado com sucesso.',
                'data'    => $user->toArray(),
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
        $user = $this->repository->find($id);
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $user,
            ]);
        }
        return view('users.show', compact('user'));
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
        $user = $this->repository->find($id);

        if(Auth::user()->isSuperAdmin()){
           $networks = Network::all()->pluck('description', 'id');
           $roles = Role::all()->pluck("name", "id");
           $stores = Store::all()->pluck("name", 'id');
           $departments = Department::all()->pluck("name", "id");
           $teams = Team::all()->pluck("name", "id");


        }elseif(Auth::user()->isAdminRede()){
            $redes = Auth::user()->networks->pluck('id');



            $networks = Network::whereIn('id',$redes->toArray() )->pluck('description', 'id');
            $roles = Role::where('id','!=', 1)->get()->pluck("name", "id");
            $stores = Store::whereIn('network_id', $redes->toArray())->pluck("name", 'id');
            $departments = whereIn('network_id', $redes->toArray())->pluck('name', 'id');
            $teams = whereIn('network_id', $redes->toArray())->pluck('name', 'id');
        }else{
            $redes = Auth::user()->networks->pluck('id');
            $roles = Auth::user()->roles->pluck('id');
            $stores = Auth::user()->stores->pluck('id');
            $departments = Auth::user()->pluck('id');
            $teams = Auth::user()->pluck('id');

            $networks = Network::whereIn('id',$redes->toArray())->pluck('description', 'id');
            $roles = Role::whereIn('id',$roles->toArray())->get()->pluck("name", "id");
            $stores = Store::whereIn('network_id', $redes->toArray())->pluck("name", 'id');
            $departments = Department::whereIn('network_id', $redes->toArray())->pluck("name", 'id');
            $teams = Department::whereIn('network_id', $redes->toArray())->pluck("name", 'id');
        }

        return view('users.edit', compact('user', 'networks', 'roles', 'stores', 'departments', 'teams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UserUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $data = $request->all();

            if($data['password'] == "" || is_null($data['password'])){
                unset($data['password']);
            }else{
                $data['password'] = bcrypt($data['password']);
            }
            $user = $this->repository->update($data, $id);
            if(isset($data['network_id']) && $data['network_id'] != ""){
                $user->networks()->sync($data['network_id']);
            }

            if(isset($data['role_id']) && $data['role_id'] != ""){
                $user->roles()->sync($data['role_id']);
            }

            if(isset($data['store_id']) && $data['store_id'] != "" && $data['store_id'][0] != null){
                $user->stores()->sync($data['store_id']);
            }

            if(isset($data['department_id']) && $data['department_id'] != "" && $data['department_id'][0] != null){
                $user->departments()->sync($data['department_id']);
            }

            if(isset($data['team_id']) && $data['team_id'] != "" && $data['team_id'][0] != null){
                $user->teams()->sync($data['team_id']);
            }
            $response = [
                'message' => 'Usuário Atualizado',
                'data'    => $user->toArray(),
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
                'message' => 'User deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'User deleted.');
    }
}
