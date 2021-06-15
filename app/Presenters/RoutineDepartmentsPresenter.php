<?php

namespace App\Presenters;

use App\Transformers\RoutineDepartmentsTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RoutineDepartmentsPresenter.
 *
 * @package namespace App\Presenters;
 */
class RoutineDepartmentsPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoutineDepartmentsTransformer();
    }
}
