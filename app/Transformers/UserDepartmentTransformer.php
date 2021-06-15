<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\UserDepartment;

/**
 * Class UserDepartmentTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserDepartmentTransformer extends TransformerAbstract
{
    /**
     * Transform the UserDepartment entity.
     *
     * @param \App\Entities\UserDepartment $model
     *
     * @return array
     */
    public function transform(UserDepartment $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
