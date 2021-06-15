<?php

namespace App\Presenters;

use App\Transformers\FlowTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FlowPresenter.
 *
 * @package namespace App\Presenters;
 */
class FlowPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FlowTransformer();
    }
}
