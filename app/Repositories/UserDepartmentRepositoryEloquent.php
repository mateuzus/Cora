<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserDepartmentRepository;
use App\Entities\UserDepartment;
use App\Validators\UserDepartmentValidator;

/**
 * Class UserDepartmentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserDepartmentRepositoryEloquent extends BaseRepository implements UserDepartmentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserDepartment::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UserDepartmentValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
