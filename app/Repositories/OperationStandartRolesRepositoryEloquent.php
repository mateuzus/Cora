<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperationStandartRolesRepository;
use App\Entities\OperationStandartRoles;
use App\Validators\OperationStandartRolesValidator;

/**
 * Class OperationStandartRolesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperationStandartRolesRepositoryEloquent extends BaseRepository implements OperationStandartRolesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OperationStandartRoles::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OperationStandartRolesValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
