<?php

namespace App\Http\Controllers\App\OperationStandart;

use App\Http\Controllers\Controller;
use App\Repositories\ListingRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * @var ListingRepository
     */
    private $repository;

    /**
     * ListingController constructor.
     */
    public function __construct(ListingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(){
        $listings = $this->repository
            ->with('questions')->findWhere(
                [
                    'operator_id'=>\request()->user()->id,
                    'creation_date'=>Carbon::now()->format('Y-m-d'),
                    ['pop_id',"!=",null]
                ]);
        return response()->json($listings);

    }
}
