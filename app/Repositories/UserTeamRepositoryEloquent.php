<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserTeamRepository;
use App\Entities\UserTeam;
use App\Validators\UserTeamValidator;

/**
 * Class UserTeamRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserTeamRepositoryEloquent extends BaseRepository implements UserTeamRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserTeam::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UserTeamValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
