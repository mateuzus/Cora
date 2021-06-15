<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RoutineRolesRepository;
use App\Entities\RoutineRoles;
use App\Validators\RoutineRolesValidator;

/**
 * Class RoutineRolesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoutineRolesRepositoryEloquent extends BaseRepository implements RoutineRolesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RoutineRoles::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RoutineRolesValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
