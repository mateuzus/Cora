<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\RoutineDepartments;

/**
 * Class RoutineDepartmentsTransformer.
 *
 * @package namespace App\Transformers;
 */
class RoutineDepartmentsTransformer extends TransformerAbstract
{
    /**
     * Transform the RoutineDepartments entity.
     *
     * @param \App\Entities\RoutineDepartments $model
     *
     * @return array
     */
    public function transform(RoutineDepartments $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
