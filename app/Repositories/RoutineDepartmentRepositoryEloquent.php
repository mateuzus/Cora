<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RoutineDepartmentRepository;
use App\Entities\RoutineDepartment;
use App\Validators\RoutineDepartmentValidator;

/**
 * Class RoutineDepartmentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoutineDepartmentRepositoryEloquent extends BaseRepository implements RoutineDepartmentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RoutineDepartment::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RoutineDepartmentValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
