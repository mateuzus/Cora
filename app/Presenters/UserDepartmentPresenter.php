<?php

namespace App\Presenters;

use App\Transformers\UserDepartmentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserDepartmentPresenter.
 *
 * @package namespace App\Presenters;
 */
class UserDepartmentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserDepartmentTransformer();
    }
}
