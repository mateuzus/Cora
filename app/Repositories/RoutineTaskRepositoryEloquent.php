<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RoutineTaskRepository;
use App\Entities\RoutineTask;
use App\Validators\RoutineTaskValidator;

/**
 * Class RoutineTaskRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoutineTaskRepositoryEloquent extends BaseRepository implements RoutineTaskRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RoutineTask::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RoutineTaskValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
