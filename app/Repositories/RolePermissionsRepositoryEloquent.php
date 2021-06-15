<?php

namespace App\Repositories;

use App\Entities\RolesPermissions;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RolePermissionsRepository;
use App\Validators\RolePermissionsValidator;

/**
 * Class RolePermissionsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RolePermissionsRepositoryEloquent extends BaseRepository implements RolePermissionsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RolesPermissions::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RolePermissionsValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
