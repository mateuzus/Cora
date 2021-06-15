<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FlowRolesRepository;
use App\Entities\FlowRoles;
use App\Validators\FlowRolesValidator;

/**
 * Class FlowRolesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FlowRolesRepositoryEloquent extends BaseRepository implements FlowRolesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FlowRoles::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FlowRolesValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
