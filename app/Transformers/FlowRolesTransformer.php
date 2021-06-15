<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\FlowRoles;

/**
 * Class FlowRolesTransformer.
 *
 * @package namespace App\Transformers;
 */
class FlowRolesTransformer extends TransformerAbstract
{
    /**
     * Transform the FlowRoles entity.
     *
     * @param \App\Entities\FlowRoles $model
     *
     * @return array
     */
    public function transform(FlowRoles $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
