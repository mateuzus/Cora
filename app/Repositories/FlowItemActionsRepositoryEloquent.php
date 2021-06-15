<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FlowItemActionsRepository;
use App\Entities\FlowItemActions;
use App\Validators\FlowItemActionsValidator;

/**
 * Class FlowItemActionsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FlowItemActionsRepositoryEloquent extends BaseRepository implements FlowItemActionsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FlowItemActions::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FlowItemActionsValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
