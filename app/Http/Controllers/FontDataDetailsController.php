<?php

namespace App\Http\Controllers;

use App\Entities\FontData;
use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\FontDataDetailCreateRequest;
use App\Http\Requests\FontDataDetailUpdateRequest;
use App\Repositories\FontDataDetailRepository;
use App\Validators\FontDataDetailValidator;

/**
 * Class FontDataDetailsController.
 *
 * @package namespace App\Http\Controllers;
 */
class FontDataDetailsController extends Controller
{
    /**
     * @var FontDataDetailRepository
     */
    protected $repository;

    /**
     * @var FontDataDetailValidator
     */
    protected $validator;

    /**
     * FontDataDetailsController constructor.
     *
     * @param FontDataDetailRepository $repository
     * @param FontDataDetailValidator $validator
     */
    public function __construct(FontDataDetailRepository $repository, FontDataDetailValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fontData = FontData::find(\request()->font_data_id);
        return view('fontDatas.details.create', compact('fontData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  FontDataDetailCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(FontDataDetailCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
            $data = $request->all();
            $data['status']=false;

            $fontDataDetail = $this->repository->create($data);

            $response = [
                'message' => 'Detalhes cadastrados com successo',
                'data'    => $fontDataDetail->toArray(),
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
        $fontDataDetail = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $fontDataDetail,
            ]);
        }

        return view('fontDatasDetails.show', compact('fontDataDetail'));
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
        $fontDataDetail = $this->repository->find($id);

        return view('fontDatas.details.edit', compact('fontDataDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  FontDataDetailUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(FontDataDetailUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $fontDataDetail = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'FontDataDetail updated.',
                'data'    => $fontDataDetail->toArray(),
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
                'message' => 'FontDataDetail deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'FontDataDetail deleted.');
    }
}
