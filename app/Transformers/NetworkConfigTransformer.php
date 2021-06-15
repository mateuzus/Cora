<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\NetworkConfig;

/**
 * Class NetworkConfigTransformer.
 *
 * @package namespace App\Transformers;
 */
class NetworkConfigTransformer extends TransformerAbstract
{
    /**
     * Transform the NetworkConfig entity.
     *
     * @param \App\Entities\NetworkConfig $model
     *
     * @return array
     */
    public function transform(NetworkConfig $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
