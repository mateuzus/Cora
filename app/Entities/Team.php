<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Team.
 *
 * @package namespace App\Entities;
 */
class Team extends Model implements Transformable
{
    use HasFactory,TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'network_id',
        'name',
        'description',
    ];

    public function network(){
        return $this->belongsTo(Network::class);
    }

}
