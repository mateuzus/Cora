<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RoutineTeamRepository;
use App\Entities\RoutineTeam;
use App\Validators\RoutineTeamValidator;

/**
 * Class RoutineTeamRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RoutineTeamRepositoryEloquent extends BaseRepository implements RoutineTeamRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RoutineTeam::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RoutineTeamValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
