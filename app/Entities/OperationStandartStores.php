<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OperationStandartStores.
 *
 * @package namespace App\Entities;
 */
class OperationStandartStores extends Model implements Transformable
{
    use TransformableTrait;
    public $table = 'operation_standart_stores';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pop_id',
        'store_id'
    ];



    public function pop(){
        return $this->belongsTo(OperationStandart::class, 'pop_id');
    }

    public function store(){
        return $this->belongsTo(Store::class, 'store_id');
    }

}
