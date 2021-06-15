<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\FontDataDetailRepository;
use App\Entities\FontDataDetail;
use App\Validators\FontDataDetailValidator;

/**
 * Class FontDataDetailRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class FontDataDetailRepositoryEloquent extends BaseRepository implements FontDataDetailRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FontDataDetail::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return FontDataDetailValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
