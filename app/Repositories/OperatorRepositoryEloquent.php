<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperatorRepository;
use App\Entities\Operator;
use App\Validators\OperatorValidator;

/**
 * Class OperatorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperatorRepositoryEloquent extends BaseRepository implements OperatorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Operator::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OperatorValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
