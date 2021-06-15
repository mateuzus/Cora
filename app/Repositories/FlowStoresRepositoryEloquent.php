<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FlowStoresRepository;
use App\Entities\FlowStores;
use App\Validators\FlowStoresValidator;

/**
 * Class FlowStoresRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FlowStoresRepositoryEloquent extends BaseRepository implements FlowStoresRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FlowStores::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FlowStoresValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
