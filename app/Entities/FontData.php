<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FontData.
 *
 * @package namespace App\Entities;
 */
class FontData extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'font_datas';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'network_id',
        'type',
        'name',
    ];


    static public function typeArray()
    {
        return [
            'api' => "API",
            'file' => "Arquivo CSV",
            'manual' => "Digitar"
        ];
    }

    public function details (){
        return $this->hasMany(FontDataDetail::class);
    }

}
