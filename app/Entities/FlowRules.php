<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FlowRules.
 *
 * @package namespace App\Entities;
 */
class FlowRules extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'flow_id',
        'order',
        'name',
        'department_id',
        'store_id',
        'role_id',
        'team_id',
        'question_type',
        'type_action',
        'trigger',
        'trigger_rule',
        'trigger_value',
        'use_network_config',
        'rule',
    ];
    public $questionTypeArray = [
        null    => "Fim de curso",
        'number_integer'    => "Número Inteiro",
        'number_decimal'    => "Número decimal",
        'boolean'           => "Verdadeiro e falso",
        'multiple_options'  => "multiplas_opcoes",
        'texto_simples'     => "multiplas_opcoes",
    ];

    public $typeArray=[
        null    => "Fim de curso",
        'send_to_list'=>"Enviar para uma lista",
        'send_to_mail'=>"Enviar por email",
        'send_to_sms'=>"Enviar por sms",
    ];

    public $triggerArray=[
        null    => "Fim de curso",
        'every'=>"Sempre",
        'question_value'=>"Valor da Pergunta",
        'flow_value'=>"Valor da Fluxo",
    ];
    public $triggerRuleArray=[
        null => "Sem regra",
        '<' => "Menor",
        '<=' => "Menor e igual",
        '=' => "Igual",
        '!=' => "Diferente",
        '>' => "Maior",
        '>=' => "Maior e igual",
        'between' => "Entre valores",
    ];


    public $appends= [
        'type_label',
        'trigger_label',
        'trigger_rule_label'
    ];

    public function getTypeLabelAttribute($value){
        return $this->typeArray[$this->type_action];
    }
    public function getTriggerLabelAttribute($value){
        return $this->triggerArray[$this->trigger];
    }
    public function getTriggerRuleLabelAttribute($value){
        return $this->triggerRuleArray[$this->trigger_rule];
    }

    public function flow(){
        return $this->belongsTo(Flow::class);
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function team(){
        return $this->belongsTo(Team::class);
    }
    public function users(){

        $network = $this->flow()->first()->network;
        $roles = $this->role()->first();

        $stores = $this->store()->first();
        $departments = $this->department()->first();
        $teams = $this->team()->first();
        $users = [];
        if($roles && $stores && $departments &&  $teams){
            $users = User::whereHas("networks", function ($query) use ($network) {
                return $query->where("networks.id", $network->id);
            })
                ->whereHas("roles", function ($query) use ($roles) {
                    return $query->where("roles.id", $roles->id);
                })
                ->whereHas("stores", function ($query) use ($stores) {
                    return $query->where("stores.id", $stores->id);
                })
                ->whereHas("departments", function ($query) use ($departments) {
                    return $query->where("departments.id", $departments->id);
                })
                ->whereHas("teams", function ($query) use ($teams) {
                    return $query->where("teams.id", $teams->id);
                })
                ->get();
        }

        return $users;
    }

}
