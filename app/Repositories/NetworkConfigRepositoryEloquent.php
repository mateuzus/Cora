<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\NetworkConfigRepository;
use App\Entities\NetworkConfig;
use App\Validators\NetworkConfigValidator;

/**
 * Class NetworkConfigRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NetworkConfigRepositoryEloquent extends BaseRepository implements NetworkConfigRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NetworkConfig::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return NetworkConfigValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
