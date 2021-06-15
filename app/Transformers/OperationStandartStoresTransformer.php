<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\OperationStandartStores;

/**
 * Class OperationStandartStoresTransformer.
 *
 * @package namespace App\Transformers;
 */
class OperationStandartStoresTransformer extends TransformerAbstract
{
    /**
     * Transform the OperationStandartStores entity.
     *
     * @param \App\Entities\OperationStandartStores $model
     *
     * @return array
     */
    public function transform(OperationStandartStores $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
