<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Listing;

/**
 * Class ListingTransformer.
 *
 * @package namespace App\Transformers;
 */
class ListingTransformer extends TransformerAbstract
{
    /**
     * Transform the Listing entity.
     *
     * @param \App\Entities\Listing $model
     *
     * @return array
     */
    public function transform(Listing $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
