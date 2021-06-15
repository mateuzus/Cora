<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\FlowRules;

/**
 * Class FlowRulesTransformer.
 *
 * @package namespace App\Transformers;
 */
class FlowRulesTransformer extends TransformerAbstract
{
    /**
     * Transform the FlowRules entity.
     *
     * @param \App\Entities\FlowRules $model
     *
     * @return array
     */
    public function transform(FlowRules $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
