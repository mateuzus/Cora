<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AdapterNetworkConnectionRepository;
use App\Entities\AdapterNetworkConnection;
use App\Validators\AdapterNetworkConnectionValidator;

/**
 * Class AdapterNetworkConnectionRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AdapterNetworkConnectionRepositoryEloquent extends BaseRepository implements AdapterNetworkConnectionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AdapterNetworkConnection::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AdapterNetworkConnectionValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
