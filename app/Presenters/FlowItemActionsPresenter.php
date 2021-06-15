<?php

namespace App\Presenters;

use App\Transformers\FlowItemActionsTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FlowItemActionsPresenter.
 *
 * @package namespace App\Presenters;
 */
class FlowItemActionsPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FlowItemActionsTransformer();
    }
}
