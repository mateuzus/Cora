<?php

namespace App\Presenters;

use App\Transformers\AdapterNetworkConnectionTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AdapterNetworkConnectionPresenter.
 *
 * @package namespace App\Presenters;
 */
class AdapterNetworkConnectionPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AdapterNetworkConnectionTransformer();
    }
}
