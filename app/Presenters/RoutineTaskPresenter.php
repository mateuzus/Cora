<?php

namespace App\Presenters;

use App\Transformers\RoutineTaskTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RoutineTaskPresenter.
 *
 * @package namespace App\Presenters;
 */
class RoutineTaskPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoutineTaskTransformer();
    }
}
