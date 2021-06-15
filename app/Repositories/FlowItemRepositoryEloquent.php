<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FlowItemRepository;
use App\Entities\FlowItem;
use App\Validators\FlowItemValidator;

/**
 * Class FlowItemRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FlowItemRepositoryEloquent extends BaseRepository implements FlowItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FlowItem::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FlowItemValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
