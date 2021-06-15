<?php

namespace App\Presenters;

use App\Transformers\ListingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ListingPresenter.
 *
 * @package namespace App\Presenters;
 */
class ListingPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ListingTransformer();
    }
}
