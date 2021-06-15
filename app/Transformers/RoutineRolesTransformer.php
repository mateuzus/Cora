<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\RoutineRoles;

/**
 * Class RoutineRolesTransformer.
 *
 * @package namespace App\Transformers;
 */
class RoutineRolesTransformer extends TransformerAbstract
{
    /**
     * Transform the RoutineRoles entity.
     *
     * @param \App\Entities\RoutineRoles $model
     *
     * @return array
     */
    public function transform(RoutineRoles $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
