<?php

namespace App\Presenters;

use App\Transformers\TeamTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TeamPresenter.
 *
 * @package namespace App\Presenters;
 */
class TeamPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TeamTransformer();
    }
}
