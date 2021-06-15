<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class AnswerGiven.
 *
 * @package namespace App\Entities;
 */
class AnswerGiven extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'response',
        'response_content',
        'type',
    ];

    public $typeArray = [
        'photo'=>"Foto",
        'number_integer'    => "Número Inteiro",
        'number_decimal'    => "Número decimal",
        'boolean'           => "Verdadeiro e falso",
    ];

    protected $casts=[
        'question_id'=>'int'
    ];

    public function question(){
        return $this->belongsTo(Question::class, 'question_id');
    }

}
