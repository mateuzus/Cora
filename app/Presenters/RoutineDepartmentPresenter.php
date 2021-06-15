<?php

namespace App\Presenters;

use App\Transformers\RoutineDepartmentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RoutineDepartmentPresenter.
 *
 * @package namespace App\Presenters;
 */
class RoutineDepartmentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoutineDepartmentTransformer();
    }
}
