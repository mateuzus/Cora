<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OperationStandartDepartmentRepository;
use App\Entities\OperationStandartDepartment;
use App\Validators\OperationStandartDepartmentValidator;

/**
 * Class OperationStandartDepartmentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OperationStandartDepartmentRepositoryEloquent extends BaseRepository implements OperationStandartDepartmentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OperationStandartDepartment::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return OperationStandartDepartmentValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
