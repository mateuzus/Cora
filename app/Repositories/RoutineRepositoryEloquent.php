<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RoutineRepository;
use App\Entities\Routine;
use App\Validators\RoutineValidator;

/**
 * Class RoutineRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoutineRepositoryEloquent extends BaseRepository implements RoutineRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Routine::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RoutineValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
