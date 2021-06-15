<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OperationStandartTask.
 *
 * @package namespace App\Entities;
 */
class OperationStandartTask extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pop_id',
        'description',
        'required',
        'type',
        'weight',
        'has_action',
        'video',
        'quantity',
    ];

    public $typeArray = [
        'number_integer' => "Número Inteiro",
        'number_decimal' => "Número decimal",
        'boolean' => "Verdadeiro e falso",
    ];

    public function pop(){
        return $this->belongsTo(OperationStandart::class, 'pop_id');
    }


}
