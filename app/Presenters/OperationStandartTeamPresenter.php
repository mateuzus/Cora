<?php

namespace App\Presenters;

use App\Transformers\OperationStandartTeamTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OperationStandartTeamPresenter.
 *
 * @package namespace App\Presenters;
 */
class OperationStandartTeamPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OperationStandartTeamTransformer();
    }
}
