<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\AnswerGiven;

/**
 * Class AnswerGivenTransformer.
 *
 * @package namespace App\Transformers;
 */
class AnswerGivenTransformer extends TransformerAbstract
{
    /**
     * Transform the AnswerGiven entity.
     *
     * @param \App\Entities\AnswerGiven $model
     *
     * @return array
     */
    public function transform(AnswerGiven $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
