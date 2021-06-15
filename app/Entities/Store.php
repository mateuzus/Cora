<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Store.
 *
 * @package namespace App\Entities;
 * @method static whereIn(string $string, $pluck)
 */
class Store extends Model implements Transformable
{
    use TransformableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'network_id',
        'description',
        'name',
        'code'
    ];

    public function network(){
        return $this->belongsTo(Network::class);
    }
}
