<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\OperationStandart;

/**
 * Class OperationStandartTransformer.
 *
 * @package namespace App\Transformers;
 */
class OperationStandartTransformer extends TransformerAbstract
{
    /**
     * Transform the OperationStandart entity.
     *
     * @param \App\Entities\OperationStandart $model
     *
     * @return array
     */
    public function transform(OperationStandart $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
