<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class FontDataDetail.
 *
 * @package namespace App\Entities;
 */
class FontDataDetail extends Model implements Transformable
{
    use TransformableTrait;

    protected $appends = ['status_description'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'font_data_id',
        'ean_code',
        'description',
        'status',
        'value',
        'url',
        'utilized_at'
    ];

   public const TYPE_STATUS = [
           0 => 'Não utilizável',
           1 => 'Utilizável'
       ];


    public $dates = ['utilized_at'];

    public function fontData(){
        return $this->belongsTo(FontData::class);

    }
    public function getStatusDescriptionAttribute($value) {
        return self::TYPE_STATUS[$this->status];
    }


}
