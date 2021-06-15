<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OperationStandartDepartment.
 *
 * @package namespace App\Entities;
 */
class OperationStandartDepartment extends Model implements Transformable
{
    use TransformableTrait;
    public $table = 'operation_standart_departments';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pop_id',
        'department_id'
    ];



        public function operationStandartDepartments(){
            return $this->belongsTo(Listing::class, 'pop_id');
        }
}
