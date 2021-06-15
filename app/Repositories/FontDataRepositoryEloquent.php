<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FontDataRepository;
use App\Entities\FontData;
use App\Validators\FontDataValidator;

/**
 * Class FontDataRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FontDataRepositoryEloquent extends BaseRepository implements FontDataRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FontData::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return FontDataValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

}
