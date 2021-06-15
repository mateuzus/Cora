<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\RoutineTask;

/**
 * Class RoutineTaskTransformer.
 *
 * @package namespace App\Transformers;
 */
class RoutineTaskTransformer extends TransformerAbstract
{
    /**
     * Transform the RoutineTask entity.
     *
     * @param \App\Entities\RoutineTask $model
     *
     * @return array
     */
    public function transform(RoutineTask $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
