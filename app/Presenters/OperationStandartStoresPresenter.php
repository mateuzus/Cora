<?php

namespace App\Presenters;

use App\Transformers\OperationStandartStoresTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OperationStandartStoresPresenter.
 *
 * @package namespace App\Presenters;
 */
class OperationStandartStoresPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OperationStandartStoresTransformer();
    }
}
