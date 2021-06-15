<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FlowTeamRepository;
use App\Entities\FlowTeam;
use App\Validators\FlowTeamValidator;

/**
 * Class FlowTeamRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FlowTeamRepositoryEloquent extends BaseRepository implements FlowTeamRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FlowTeam::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FlowTeamValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
