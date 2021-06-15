<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperationStandartStoresRepository;
use App\Entities\OperationStandartStores;
use App\Validators\OperationStandartStoresValidator;

/**
 * Class OperationStandartStoresRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperationStandartStoresRepositoryEloquent extends BaseRepository implements OperationStandartStoresRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OperationStandartStores::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OperationStandartStoresValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
