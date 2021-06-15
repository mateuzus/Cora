<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\OperationStandartTeam;

/**
 * Class OperationStandartTeamTransformer.
 *
 * @package namespace App\Transformers;
 */
class OperationStandartTeamTransformer extends TransformerAbstract
{
    /**
     * Transform the OperationStandartTeam entity.
     *
     * @param \App\Entities\OperationStandartTeam $model
     *
     * @return array
     */
    public function transform(OperationStandartTeam $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
