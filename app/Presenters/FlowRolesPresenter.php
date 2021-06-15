<?php

namespace App\Presenters;

use App\Transformers\FlowRolesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FlowRolesPresenter.
 *
 * @package namespace App\Presenters;
 */
class FlowRolesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FlowRolesTransformer();
    }
}
