<?php

namespace App\Presenters;

use App\Transformers\FlowItemTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FlowItemPresenter.
 *
 * @package namespace App\Presenters;
 */
class FlowItemPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FlowItemTransformer();
    }
}
