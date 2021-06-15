<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\FontDataDetail;

/**
 * Class FontDataDetailTransformer.
 *
 * @package namespace App\Transformers;
 */
class FontDataDetailTransformer extends TransformerAbstract
{
    /**
     * Transform the FontDataDetail entity.
     *
     * @param \App\Entities\FontDataDetail $model
     *
     * @return array
     */
    public function transform(FontDataDetail $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
