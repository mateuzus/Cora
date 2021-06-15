<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\FontData;

/**
 * Class FontDataTransformer.
 *
 * @package namespace App\Transformers;
 */
class FontDataTransformer extends TransformerAbstract
{
    /**
     * Transform the FontData entity.
     *
     * @param \App\Entities\FontData $model
     *
     * @return array
     */
    public function transform(FontData $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
