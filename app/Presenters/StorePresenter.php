<?php

namespace App\Presenters;

use App\Transformers\StoreTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class StorePresenter.
 *
 * @package namespace App\Presenters;
 */
class StorePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new StoreTransformer();
    }
}
