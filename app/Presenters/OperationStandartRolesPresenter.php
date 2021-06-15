<?php

namespace App\Presenters;

use App\Transformers\OperationStandartRolesTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OperationStandartRolesPresenter.
 *
 * @package namespace App\Presenters;
 */
class OperationStandartRolesPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OperationStandartRolesTransformer();
    }
}
