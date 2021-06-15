<?php

namespace App\Presenters;

use App\Transformers\RoutineTeamTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RoutineTeamPresenter.
 *
 * @package namespace App\Presenters;
 */
class RoutineTeamPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RoutineTeamTransformer();
    }
}
