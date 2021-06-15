<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Network;

/**
 * Class NetworkTransformer.
 *
 * @package namespace App\Transformers;
 */
class NetworkTransformer extends TransformerAbstract
{
    /**
     * Transform the Network entity.
     *
     * @param \App\Entities\Network $model
     *
     * @return array
     */
    public function transform(Network $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
