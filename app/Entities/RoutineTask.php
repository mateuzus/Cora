<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class RoutineTask.
 *
 * @package namespace App\Entities;
 */
class RoutineTask extends Model implements Transformable
{
    use TransformableTrait;
    public $table = 'routine_tasks';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'routine_id',
        'description',
        'required',
        'type',
        'weight',
        'has_action',
        'video',
        'quantity',
    ];

    public function routine(){
        return $this->belongsTo(Routine::class, 'routine_id');
    }

}
