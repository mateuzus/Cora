<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Routine;

/**
 * Class RoutineTransformer.
 *
 * @package namespace App\Transformers;
 */
class RoutineTransformer extends TransformerAbstract
{
    /**
     * Transform the Routine entity.
     *
     * @param \App\Entities\Routine $model
     *
     * @return array
     */
    public function transform(Routine $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
