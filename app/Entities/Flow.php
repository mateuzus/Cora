<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Flow.
 *
 * @package namespace App\Entities;
 */
class Flow extends Model implements Transformable
{
    use TransformableTrait;


        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'network_id',
        'font_data_id',
        'name',
        'description',
        'type',
        'schedule',
        'day',
        'time',
        'duration_days',
        'duration_hours',
        'duration_minutes',
        'status',
    ];


    public $typeArray = [
      'operation_standart'=>"Pop",
      'routines'=>"Rotinas",
      'open_and_close_stores'=>"Abertura e fechamento de loja",
      'work_flow'=>"Fluxo de Trabalho",
      'training_flow'=>"Fluxo de Treinamento",
      'free_flow'=>"Fluxo Livre"
    ];

    public function network(){
        return $this->belongsTo(Network::class);
    }
    public function stores(){
        return $this->belongsToMany(Store::class, FlowStores::class, 'flow_id');
    }
    public function roles(){
        return $this->belongsToMany(Role::class, FlowRoles::class, 'flow_id');
    }
    public function departments(){
        return $this->belongsToMany(Department::class, FlowDepartments::class, 'flow_id');
    }
    public function teams(){
        return $this->belongsToMany(Team::class, FlowTeam::class, 'flow_id');
    }

    public function fontData(){
        return $this->belongsTo(FontData::class);
    }
    public function rules(){
        return $this->hasMany(FlowRules::class, 'flow_id');
    }


    public function getEndDate(){
        return Carbon::now()->addDays($this->duration_days)->addHours($this->duration_hours)->addMinutes($this->duration_minutes);
    }






}
