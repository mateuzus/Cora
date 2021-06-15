<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OperationStandartRoles.
 *
 * @package namespace App\Entities;
 */
class OperationStandartRoles extends Model implements Transformable
{
    use TransformableTrait;
    public $table = 'operation_standart_roles';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pop_id',
        'role_id'
    ];



        public function pop(){
            return $this->belongsTo(OperationStandart::class, 'pop_id');
        }

        public function role(){
            return $this->belongsTo(Role::class, 'role_id');
        }
}
