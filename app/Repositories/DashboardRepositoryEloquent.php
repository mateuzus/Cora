<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\DashboardRepository;
use App\Entities\Dashboard;
use App\Validators\DashboardValidator;

/**
 * Class DashboardRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DashboardRepositoryEloquent extends BaseRepository implements DashboardRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Dashboard::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
