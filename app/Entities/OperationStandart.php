<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OperationStandart.
 *
 * @package namespace App\Entities;
 */
class OperationStandart extends Model implements Transformable
{
    use TransformableTrait;



    protected $fillable = [
        'network_id',
        'flow_id',
        'code',
        'sector',
        'name',
        'target',
        'references',
        'material',
        'schedule',
        'day',
        'time',
        'image',
        'description',
        'duration_days',
        'duration_hours',
        'duration_minutes',
        'status',
    ];


    public function network(){
        return $this->belongsTo(Network::class);
    }
    public function flow(){
        return $this->belongsTo(Flow::class);
    }

    public function stores(){
        return $this->belongsToMany(Store::class, OperationStandartStores::class, 'pop_id');
    }
    public function roles(){
        return $this->belongsToMany(Role::class, OperationStandartRoles::class, 'pop_id');
    }
    public function departments(){
        return $this->belongsToMany(Department::class, OperationStandartDepartment::class, 'pop_id');
    }
    public function teams(){
        return $this->belongsToMany(Team::class, OperationStandartTeam::class, 'pop_id');
    }


    public function getEndDate(){
        return Carbon::now()->addDays($this->duration_days)->addHours($this->duration_hours)->addMinutes($this->duration_minutes);
    }

}
