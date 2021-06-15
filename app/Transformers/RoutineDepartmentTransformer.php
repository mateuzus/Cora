<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\RoutineDepartment;

/**
 * Class RoutineDepartmentTransformer.
 *
 * @package namespace App\Transformers;
 */
class RoutineDepartmentTransformer extends TransformerAbstract
{
    /**
     * Transform the RoutineDepartment entity.
     *
     * @param \App\Entities\RoutineDepartment $model
     *
     * @return array
     */
    public function transform(RoutineDepartment $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
