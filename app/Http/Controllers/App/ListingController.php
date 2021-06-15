<?php

namespace App\Http\Controllers\App;

use App\Entities\Listing;
use App\Entities\User;
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
     * @var Listing
     */
    private $listing;

    /**
     * ListingController constructor.
     * @param ListingRepository $repository
     * @param Listing $listing
     */
    public function __construct(ListingRepository $repository, Listing $listing)
    {
        $this->repository = $repository;
        $this->listing = $listing;
    }
    public function index(Request $request){
        $type = $request->type;
        $listings = $this->listing
            ->with([
                'user',
                'network',
                'store',
                'department',
                'flow',
                'pop',
                'routine',
                'questions',
            ])
            ->today();
        if($request->user_id){
            $listings = $listings->listingUser(User::find(\request()->user_id));
        }else{
            $listings = $listings->listingUser(\request()->user());
        }


        switch ($type){
            case 'flow_of_work':
                $listings->listingWork();
                break;
            case 'prices':
                $listings->listingPrices();
                break;
            case 'audits':
                $listings->listingAudits();
                break;
            case 'pops':
                $listings->listingPops();
                break;
            case 'routines':
                $listings->listingRoutines();
                break;
            case 'noncompliances':
                $listings->listingNoncompliances();
                break;
            case 'resupplements':
                $listings->listingResupplements();
                break;

        }
        return response()->json($listings->get());

    }
}
