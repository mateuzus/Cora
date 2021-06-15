<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use PDO;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Network.
 *
 * @package namespace App\Entities;
 * @method static whereIn(string $string, $pluck)
 */
class Network extends Model implements Transformable
{


    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'status',
    ];


    public function fontDatas()
    {
        return $this->hasMany(FontData::class);
    }


    public function config()
    {
        return $this->hasMany(NetworkConfig::class);
    }

    public function users(){
        return $this->belongsToMany(Network::class, "user_networks");
    }

    public function scopeActive($query){
        return $query->where('status', true);
    }



}
