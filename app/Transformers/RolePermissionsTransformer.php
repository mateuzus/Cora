<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\RolesPermissions;

/**
 * Class RolePermissionsTransformer.
 *
 * @package namespace App\Transformers;
 */
class RolePermissionsTransformer extends TransformerAbstract
{
    /**
     * Transform the RolePermissions entity.
     *
     * @param \App\Entities\RolesPermissions $model
     *
     * @return array
     */
    public function transform(RolesPermissions $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
