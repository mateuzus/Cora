<?php

namespace App\Presenters;

use App\Transformers\FontDataDetailTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class FontDataDetailPresenter.
 *
 * @package namespace App\Presenters;
 */
class FontDataDetailPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new FontDataDetailTransformer();
    }
}
