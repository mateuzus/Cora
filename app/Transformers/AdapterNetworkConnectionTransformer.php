<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\AdapterNetworkConnection;

/**
 * Class AdapterNetworkConnectionTransformer.
 *
 * @package namespace App\Transformers;
 */
class AdapterNetworkConnectionTransformer extends TransformerAbstract
{
    /**
     * Transform the AdapterNetworkConnection entity.
     *
     * @param \App\Entities\AdapterNetworkConnection $model
     *
     * @return array
     */
    public function transform(AdapterNetworkConnection $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
