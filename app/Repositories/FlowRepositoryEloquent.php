<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FlowRepository;
use App\Entities\Flow;
use App\Validators\FlowValidator;

/**
 * Class FlowRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FlowRepositoryEloquent extends BaseRepository implements FlowRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Flow::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FlowValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
