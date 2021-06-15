<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FlowRulesRepository;
use App\Entities\FlowRules;
use App\Validators\FlowRulesValidator;

/**
 * Class FlowRulesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FlowRulesRepositoryEloquent extends BaseRepository implements FlowRulesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FlowRules::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FlowRulesValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
