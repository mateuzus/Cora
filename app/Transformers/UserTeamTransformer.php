<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\UserTeam;

/**
 * Class UserTeamTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserTeamTransformer extends TransformerAbstract
{
    /**
     * Transform the UserTeam entity.
     *
     * @param \App\Entities\UserTeam $model
     *
     * @return array
     */
    public function transform(UserTeam $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
