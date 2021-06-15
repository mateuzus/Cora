<?php

namespace App\Entities;

use App\Entities\Adapter\Department;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Routine.
 *
 * @package namespace App\Entities;
 */
class Routine extends Model implements Transformable
{
    use TransformableTrait;
    public $table = 'routines';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'network_id',
        'font_data_id',
        'name',
        'schedule',
        'day',
        'time',
        'image',
        'description',
        'status',
    ];

    public function fontData(){
        return $this->belongsTo(FontData::class);
    }

    public function network(){
        return $this->belongsTo(Network::class, 'network_id');
    }

    public function stores(){
        return $this->belongsToMany(Store::class, RoutineStore::class);
    }
    public function roles(){
        return $this->belongsToMany(Role::class, RoutineRole::class);
    }
    public function departments(){
        return $this->belongsToMany(\App\Entities\Department::class, RoutineDepartment::class);
    }
    public function tasks(){
        return $this->hasMany(RoutineTask::class);
    }

}
