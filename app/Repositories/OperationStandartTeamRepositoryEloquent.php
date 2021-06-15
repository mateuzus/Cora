<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperationStandartTeamRepository;
use App\Entities\OperationStandartTeam;
use App\Validators\OperationStandartTeamValidator;

/**
 * Class OperationStandartTeamRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperationStandartTeamRepositoryEloquent extends BaseRepository implements OperationStandartTeamRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OperationStandartTeam::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OperationStandartTeamValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
