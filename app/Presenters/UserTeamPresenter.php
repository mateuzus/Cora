<?php

namespace App\Presenters;

use App\Transformers\UserTeamTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserTeamPresenter.
 *
 * @package namespace App\Presenters;
 */
class UserTeamPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserTeamTransformer();
    }
}
