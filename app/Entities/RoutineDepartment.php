<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class RoutineDepartment.
 *
 * @package namespace App\Entities;
 */
class RoutineDepartment extends Model implements Transformable
{
    use TransformableTrait;
    public $table = 'routine_departments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'routine_id',
        'department_id'
    ];

    public function routine(){
        return $this->belongsTo(Routine::class);
    }
    public function departments(){
        return $this->belongsTo(Department::class);
    }
}
