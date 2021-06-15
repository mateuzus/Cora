<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperationStandartRepository;
use App\Entities\OperationStandart;
use App\Validators\OperationStandartValidator;

/**
 * Class OperationStandartRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperationStandartRepositoryEloquent extends BaseRepository implements OperationStandartRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OperationStandart::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OperationStandartValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
