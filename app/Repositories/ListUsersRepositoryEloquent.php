<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ListUsersRepository;
use App\Entities\ListUsers;
use App\Validators\ListUsersValidator;

/**
 * Class ListUsersRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ListUsersRepositoryEloquent extends BaseRepository implements ListUsersRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ListUsersValidator::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
