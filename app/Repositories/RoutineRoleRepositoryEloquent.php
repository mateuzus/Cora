<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RoutineRoleRepository;
use App\Entities\RoutineRole;
use App\Validators\RoutineRoleValidator;

/**
 * Class RoutineRoleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoutineRoleRepositoryEloquent extends BaseRepository implements RoutineRoleRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RoutineRole::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RoutineRoleValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
