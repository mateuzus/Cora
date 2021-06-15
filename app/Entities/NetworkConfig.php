<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class NetworkConfig.
 *
 * @package namespace App\Entities;
 */
class NetworkConfig extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'network_id',
        'price_lowering_rules',
    ];

    public function network(){
        return $this->belongsTo(Network::class);
    }

}
