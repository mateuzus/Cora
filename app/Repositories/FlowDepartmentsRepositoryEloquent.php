<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FlowDepartmentsRepository;
use App\Entities\FlowDepartments;
use App\Validators\FlowDepartmentsValidator;

/**
 * Class FlowDepartmentsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FlowDepartmentsRepositoryEloquent extends BaseRepository implements FlowDepartmentsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FlowDepartments::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FlowDepartmentsValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
