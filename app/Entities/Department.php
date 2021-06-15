<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Department.
 *
 * @package namespace App\Entities;
 * @method static whereIn(string $string, $pluck)
 */
class Department extends Model implements Transformable
{
    use HasFactory, TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'network_id',
        'code',
        'name',
        'status',
    ];

    public function network(){
        return $this->belongsTo(Network::class);
    }

}
