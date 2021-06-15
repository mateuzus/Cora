<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AnswerGivenCreateRequest;
use App\Http\Requests\AnswerGivenUpdateRequest;
use App\Repositories\AnswerGivenRepository;
use App\Validators\AnswerGivenValidator;

/**
 * Class AnswerGivensController.
 *
 * @package namespace App\Http\Controllers;
 */
class AnswerGivensController extends Controller
{
    /**
     * @var AnswerGivenRepository
     */
    protected $repository;

    /**
     * @var AnswerGivenValidator
     */
    protected $validator;

    /**
     * AnswerGivensController constructor.
     *
     * @param AnswerGivenRepository $repository
     * @param AnswerGivenValidator $validator
     */
    public function __construct(AnswerGivenRepository $repository, AnswerGivenValidator $validator)
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
        $answerGivens = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $answerGivens,
            ]);
        }

        return view('answerGivens.index', compact('answerGivens'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AnswerGivenCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(AnswerGivenCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $answerGiven = $this->repository->create($request->all());

            $response = [
                'message' => 'AnswerGiven created.',
                'data'    => $answerGiven->toArray(),
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
        $answerGiven = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $answerGiven,
            ]);
        }

        return view('answerGivens.show', compact('answerGiven'));
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
        $answerGiven = $this->repository->find($id);

        return view('answerGivens.edit', compact('answerGiven'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AnswerGivenUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(AnswerGivenUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $answerGiven = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'AnswerGiven updated.',
                'data'    => $answerGiven->toArray(),
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
                'message' => 'AnswerGiven deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'AnswerGiven deleted.');
    }
}
