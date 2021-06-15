<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Store;

/**
 * Class StoreTransformer.
 *
 * @package namespace App\Transformers;
 */
class StoreTransformer extends TransformerAbstract
{
    /**
     * Transform the Store entity.
     *
     * @param \App\Entities\Store $model
     *
     * @return array
     */
    public function transform(Store $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
