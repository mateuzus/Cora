<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Team;

/**
 * Class TeamTransformer.
 *
 * @package namespace App\Transformers;
 */
class TeamTransformer extends TransformerAbstract
{
    /**
     * Transform the Team entity.
     *
     * @param \App\Entities\Team $model
     *
     * @return array
     */
    public function transform(Team $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
