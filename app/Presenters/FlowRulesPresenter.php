<?php

namespace App\Presenters;

use App\Transformers\FlowRulesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FlowRulesPresenter.
 *
 * @package namespace App\Presenters;
 */
class FlowRulesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FlowRulesTransformer();
    }
}
