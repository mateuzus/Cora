<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\FlowStores;

/**
 * Class FlowStoresTransformer.
 *
 * @package namespace App\Transformers;
 */
class FlowStoresTransformer extends TransformerAbstract
{
    /**
     * Transform the FlowStores entity.
     *
     * @param \App\Entities\FlowStores $model
     *
     * @return array
     */
    public function transform(FlowStores $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
