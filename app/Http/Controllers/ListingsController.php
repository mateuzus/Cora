<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ListingCreateRequest;
use App\Http\Requests\ListingUpdateRequest;
use App\Repositories\ListingRepository;
use App\Validators\ListingValidator;

/**
 * Class ListingsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ListingsController extends Controller
{
    /**
     * @var ListingRepository
     */
    protected $repository;

    /**
     * @var ListingValidator
     */
    protected $validator;

    /**
     * ListingsController constructor.
     *
     * @param ListingRepository $repository
     * @param ListingValidator $validator
     */
    public function __construct(ListingRepository $repository, ListingValidator $validator)
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


        if (request()->wantsJson()) {
            $listings = $this->repository->all();
            return response()->json([
                'data' => $listings,
            ]);
        }

        return view('front.listings.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ListingCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ListingCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $listing = $this->repository->create($request->all());

            $response = [
                'message' => 'Listing created.',
                'data'    => $listing->toArray(),
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
        $listing = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $listing,
            ]);
        }

        return view('listings.show', compact('listing'));
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
        $listing = $this->repository->find($id);

        return view('listings.edit', compact('listing'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ListingUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ListingUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $listing = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Listing updated.',
                'data'    => $listing->toArray(),
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
                'message' => 'Listing deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Listing deleted.');
    }
}
