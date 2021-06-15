<?php

namespace App\Presenters;

use App\Transformers\NetworkTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NetworkPresenter.
 *
 * @package namespace App\Presenters;
 */
class NetworkPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NetworkTransformer();
    }
}
