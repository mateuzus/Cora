<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperationStandartTaskRepository;
use App\Entities\OperationStandartTask;
use App\Validators\OperationStandartTaskValidator;

/**
 * Class OperationStandartTaskRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperationStandartTaskRepositoryEloquent extends BaseRepository implements OperationStandartTaskRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OperationStandartTask::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OperationStandartTaskValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
