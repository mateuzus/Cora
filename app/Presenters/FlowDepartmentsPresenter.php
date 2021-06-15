<?php

namespace App\Presenters;

use App\Transformers\FlowDepartmentsTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FlowDepartmentsPresenter.
 *
 * @package namespace App\Presenters;
 */
class FlowDepartmentsPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FlowDepartmentsTransformer();
    }
}
