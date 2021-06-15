<?php

namespace App\Presenters;

use App\Transformers\FlowTeamTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FlowTeamPresenter.
 *
 * @package namespace App\Presenters;
 */
class FlowTeamPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FlowTeamTransformer();
    }
}
