<?php

namespace App\Presenters;

use App\Transformers\RoutineTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RoutinePresenter.
 *
 * @package namespace App\Presenters;
 */
class RoutinePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoutineTransformer();
    }
}
