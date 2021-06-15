<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\FlowTeam;

/**
 * Class FlowTeamTransformer.
 *
 * @package namespace App\Transformers;
 */
class FlowTeamTransformer extends TransformerAbstract
{
    /**
     * Transform the FlowTeam entity.
     *
     * @param \App\Entities\FlowTeam $model
     *
     * @return array
     */
    public function transform(FlowTeam $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
