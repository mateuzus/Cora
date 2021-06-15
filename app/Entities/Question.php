<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Question.
 *
 * @package namespace App\Entities;
 */
class Question extends Model implements Transformable
{
    use HasFactory,TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'list_id',
        'rule_id',
        'product_id',
        'description',
        'mandatory',

        'question_type',
        'weight_question',
        'has_action',
        'link_video',
        'amount',
        'ean_code',
        'status',
    ];

    public $statusArray = [
        false => "NÃO INICIADA",
        true => "FINALIZADA",
    ];

    public $typesArray= [
        'number_integer'    => "Número Inteiro",
        'number_decimal'    => "Número decimal",
        'boolean'           => "Verdadeiro e falso",
        'multiplas_opcoes'  => "multiplas_opcoes",
        'texto_simples'     => "multiplas_opcoes",
    ];

    public $appends = [
        'type_label'
    ];

    public function getTypeLabelAttribute(){
        return $this->typesArray[$this->question_type];
    }

    public function listing(){
        return $this->belongsTo(Listing::class, 'list_id');
    }
    public function answersGiven(){
        return $this->hasMany(AnswerGiven::class, 'question_id');
    }
    public function possibleAnswer(){
        return $this->hasMany(PossibleAnswer::class, 'question_id');
    }

    public function rule(){
        return $this->belongsTo(FlowRules::class);
    }

    public function scopeJoinLists($query, $listing){
        return $query
            ->join('list', 'question.list_id','=','list.id')
            ->join('operator', 'list.operator_id','=','operator.id')
            ->whereIn('list_id', $listing);
    }
}
