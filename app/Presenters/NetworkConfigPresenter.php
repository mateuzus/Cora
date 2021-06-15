<?php

namespace App\Presenters;

use App\Transformers\NetworkConfigTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class NetworkConfigPresenter.
 *
 * @package namespace App\Presenters;
 */
class NetworkConfigPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new NetworkConfigTransformer();
    }
}
