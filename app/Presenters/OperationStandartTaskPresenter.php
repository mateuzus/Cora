<?php

namespace App\Presenters;

use App\Transformers\OperationStandartTaskTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OperationStandartTaskPresenter.
 *
 * @package namespace App\Presenters;
 */
class OperationStandartTaskPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OperationStandartTaskTransformer();
    }
}
