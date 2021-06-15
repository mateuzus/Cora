<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RoutineStoreRepository;
use App\Entities\RoutineStore;
use App\Validators\RoutineStoreValidator;

/**
 * Class RoutineStoreRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoutineStoreRepositoryEloquent extends BaseRepository implements RoutineStoreRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RoutineStore::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RoutineStoreValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
