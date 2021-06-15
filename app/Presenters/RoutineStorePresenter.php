<?php

namespace App\Presenters;

use App\Transformers\RoutineStoreTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RoutineStorePresenter.
 *
 * @package namespace App\Presenters;
 */
class RoutineStorePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoutineStoreTransformer();
    }
}
