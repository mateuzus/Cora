<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RoutineDepartmentsRepository;
use App\Entities\RoutineDepartments;
use App\Validators\RoutineDepartmentsValidator;

/**
 * Class RoutineDepartmentsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoutineDepartmentsRepositoryEloquent extends BaseRepository implements RoutineDepartmentsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RoutineDepartments::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RoutineDepartmentsValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
