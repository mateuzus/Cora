<?php

namespace App\Presenters;

use App\Transformers\FlowStoresTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FlowStoresPresenter.
 *
 * @package namespace App\Presenters;
 */
class FlowStoresPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FlowStoresTransformer();
    }
}
