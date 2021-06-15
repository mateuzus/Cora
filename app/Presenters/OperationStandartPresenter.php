<?php

namespace App\Presenters;

use App\Transformers\OperationStandartTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OperationStandartPresenter.
 *
 * @package namespace App\Presenters;
 */
class OperationStandartPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OperationStandartTransformer();
    }
}
