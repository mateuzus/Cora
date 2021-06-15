<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class RoutineStore.
 *
 * @package namespace App\Entities;
 */
class RoutineStore extends Model implements Transformable
{
    use TransformableTrait;
    public $table = 'routine_stores';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'routines_id',
        'store_id'
    ];

    public function routine(){
        return $this->belongsTo(Routine::class, 'routines_id');
    }

    public function store(){
        return $this->belongsTo(Store::class, 'store_id');
    }
}
