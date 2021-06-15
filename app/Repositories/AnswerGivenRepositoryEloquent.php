<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\AnswerGivenRepository;
use App\Entities\AnswerGiven;
use App\Validators\AnswerGivenValidator;

/**
 * Class AnswerGivenRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AnswerGivenRepositoryEloquent extends BaseRepository implements AnswerGivenRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return AnswerGiven::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return AnswerGivenValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
