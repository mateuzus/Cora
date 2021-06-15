<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\FlowItemActions;

/**
 * Class FlowItemActionsTransformer.
 *
 * @package namespace App\Transformers;
 */
class FlowItemActionsTransformer extends TransformerAbstract
{
    /**
     * Transform the FlowItemActions entity.
     *
     * @param \App\Entities\FlowItemActions $model
     *
     * @return array
     */
    public function transform(FlowItemActions $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
