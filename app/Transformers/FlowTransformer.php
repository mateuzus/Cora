<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Flow;

/**
 * Class FlowTransformer.
 *
 * @package namespace App\Transformers;
 */
class FlowTransformer extends TransformerAbstract
{
    /**
     * Transform the Flow entity.
     *
     * @param \App\Entities\Flow $model
     *
     * @return array
     */
    public function transform(Flow $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
