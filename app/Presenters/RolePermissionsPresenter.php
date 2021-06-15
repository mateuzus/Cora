<?php

namespace App\Presenters;

use App\Transformers\RolePermissionsTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RolePermissionsPresenter.
 *
 * @package namespace App\Presenters;
 */
class RolePermissionsPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RolePermissionsTransformer();
    }
}
