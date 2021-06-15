<?php

namespace App\Presenters;

use App\Transformers\FontDataTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FontDataPresenter.
 *
 * @package namespace App\Presenters;
 */
class FontDataPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FontDataTransformer();
    }
}
