<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\FlowDepartments;

/**
 * Class FlowDepartmentsTransformer.
 *
 * @package namespace App\Transformers;
 */
class FlowDepartmentsTransformer extends TransformerAbstract
{
    /**
     * Transform the FlowDepartments entity.
     *
     * @param \App\Entities\FlowDepartments $model
     *
     * @return array
     */
    public function transform(FlowDepartments $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
