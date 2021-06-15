<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\OperationStandartRoles;

/**
 * Class OperationStandartRolesTransformer.
 *
 * @package namespace App\Transformers;
 */
class OperationStandartRolesTransformer extends TransformerAbstract
{
    /**
     * Transform the OperationStandartRoles entity.
     *
     * @param \App\Entities\OperationStandartRoles $model
     *
     * @return array
     */
    public function transform(OperationStandartRoles $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
