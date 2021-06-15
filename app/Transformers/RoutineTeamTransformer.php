<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\RoutineTeam;

/**
 * Class RoutineTeamTransformer.
 *
 * @package namespace App\Transformers;
 */
class RoutineTeamTransformer extends TransformerAbstract
{
    /**
     * Transform the RoutineTeam entity.
     *
     * @param \App\Entities\RoutineTeam $model
     *
     * @return array
     */
    public function transform(RoutineTeam $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
