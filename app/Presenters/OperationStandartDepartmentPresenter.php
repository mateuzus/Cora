<?php

namespace App\Presenters;

use App\Transformers\OperationStandartDepartmentTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OperationStandartDepartmentPresenter.
 *
 * @package namespace App\Presenters;
 */
class OperationStandartDepartmentPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OperationStandartDepartmentTransformer();
    }
}
