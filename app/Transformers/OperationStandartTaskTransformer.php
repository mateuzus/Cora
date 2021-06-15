<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\OperationStandartTask;

/**
 * Class OperationStandartTaskTransformer.
 *
 * @package namespace App\Transformers;
 */
class OperationStandartTaskTransformer extends TransformerAbstract
{
    /**
     * Transform the OperationStandartTask entity.
     *
     * @param \App\Entities\OperationStandartTask $model
     *
     * @return array
     */
    public function transform(OperationStandartTask $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
