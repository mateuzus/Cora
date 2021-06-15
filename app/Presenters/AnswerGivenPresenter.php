<?php

namespace App\Presenters;

use App\Transformers\AnswerGivenTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class AnswerGivenPresenter.
 *
 * @package namespace App\Presenters;
 */
class AnswerGivenPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new AnswerGivenTransformer();
    }
}
