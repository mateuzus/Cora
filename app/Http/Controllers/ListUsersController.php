<?php

namespace App\Http\Controllers;

use App\Entities\Department;
use App\Entities\Flow;
use App\Entities\Listing;
use App\Entities\Network;
use App\Entities\Store;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Auth;


/**
 * Class ListUsersController.
 *
 * @property  repository
 * @package namespace App\Http\Controllers;
 */
class ListUsersController extends Controller
{
    /**
     * @var Repository
     */

    private $repository;

    public function __construct(Listing $repository)
    {
       $this->repository = $repository;
    }


    public function index(){
        //$lists = $this->repository::with('questions')->today()->where('user_id', Auth::user()->id)->get();
        $lists = $this->repository::with('questions')->where('user_id', Auth::user()->id)->get();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $lists,
            ]);
        }

        return view('lists.index', compact('lists'));
    }

    public function create(){

        if(Auth::user()->isSuperAdmin()){
            $lists = Network::all()->pluck('description', 'id');
            $stores = Store::all()->pluck('name', 'id');
            $departments = Department::all()->pluck('name', 'id');
            $flows = Flow::all()->pluck('flow_chained_id', 'id');
        }else{
            $lists = Network::whereIn('id', Auth::user()->pluck('id'))->pluck('description', 'id');
            $stores = Store::whereIn('id', Auth::user()->pluck('id'))->pluck('description', 'id');
            $departments = Department::whereIn('id', Auth::user()->pluck('id'))->pluck('description', 'id');
        }

        return view("lists.create", compact('lists', 'stores', 'departments', 'flows'));
    }

}
