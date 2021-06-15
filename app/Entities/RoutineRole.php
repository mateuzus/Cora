<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class RoutineRole.
 *
 * @package namespace App\Entities;
 */
class RoutineRole extends Model implements Transformable
{
    use TransformableTrait;
    public $table = 'routine_roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'routine_id',
        'role_id'
    ];

    public function routine(){
        return $this->belongsTo(Routine::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
}
}
