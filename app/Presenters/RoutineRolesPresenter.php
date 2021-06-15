<?php

namespace App\Presenters;

use App\Transformers\RoutineRolesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RoutineRolesPresenter.
 *
 * @package namespace App\Presenters;
 */
class RoutineRolesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoutineRolesTransformer();
    }
}
