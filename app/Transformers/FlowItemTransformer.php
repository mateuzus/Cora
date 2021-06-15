<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\FlowItem;

/**
 * Class FlowItemTransformer.
 *
 * @package namespace App\Transformers;
 */
class FlowItemTransformer extends TransformerAbstract
{
    /**
     * Transform the FlowItem entity.
     *
     * @param \App\Entities\FlowItem $model
     *
     * @return array
     */
    public function transform(FlowItem $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
