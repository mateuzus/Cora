<?php

namespace App\Http\Controllers;

use App\Entities\FontData;
use App\Entities\Network;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FontDataCreateRequest;
use App\Http\Requests\FontDataUpdateRequest;
use App\Repositories\FontDataRepository;
use App\Validators\FontDataValidator;

/**
 * Class FontDatasController.
 *
 * @package namespace App\Http\Controllers;
 */
class FontDatasController extends Controller
{
    /**
     * @var FontDataRepository
     */
    protected $repository;

    /**
     * @var FontDataValidator
     */
    protected $validator;

    /**
     * FontDatasController constructor.
     *
     * @param FontDataRepository $repository
     * @param FontDataValidator $validator
     */
    public function __construct(FontDataRepository $repository, FontDataValidator $validator)
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
        $fontDatas = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $fontDatas,
            ]);
        }

        return view('fontDatas.index', compact('fontDatas'));
    }

    public function create(){
        if(Auth::user()->isSuperAdmin()){
            $networks = Network::all()->pluck('description', 'id');
            $fontData = FontData::all()->pluck('type', 'id');
        }else{

        }
        return view('fontDatas.create', compact('fontData', 'networks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FontDataCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(FontDataCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $fontData = $this->repository->create($request->all());

            $response = [
                'message' => 'Fonte de dados cadastrada com sucesso.',
                'data'    => $fontData->toArray(),
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
        $fontData = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $fontData,
            ]);
        }

        return view('fontDatas.show', compact('fontData'));
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
        $fontDatas = $this->repository->find($id);
        $networks = Network::all()->pluck('description', 'id');

        return view('fontDatas.edit', compact('fontDatas','networks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FontDataUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(FontDataUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $fontData = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Fonte de dados atualizada com sucesso.',
                'data'    => $fontData->toArray(),
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
                'message' => 'FontData deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'FontData deleted.');
    }
}
