<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\OperationStandartDepartment;

/**
 * Class OperationStandartDepartmentTransformer.
 *
 * @package namespace App\Transformers;
 */
class OperationStandartDepartmentTransformer extends TransformerAbstract
{
    /**
     * Transform the OperationStandartDepartment entity.
     *
     * @param \App\Entities\OperationStandartDepartment $model
     *
     * @return array
     */
    public function transform(OperationStandartDepartment $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
