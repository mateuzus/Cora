<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\RoutineStore;

/**
 * Class RoutineStoreTransformer.
 *
 * @package namespace App\Transformers;
 */
class RoutineStoreTransformer extends TransformerAbstract
{
    /**
     * Transform the RoutineStore entity.
     *
     * @param \App\Entities\RoutineStore $model
     *
     * @return array
     */
    public function transform(RoutineStore $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
