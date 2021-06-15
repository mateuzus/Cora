<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Audit.
 *
 * @package namespace App\Entities;
 */
class Audit extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'user_id',
        'creation_date',
        'type',
        'status',
        'list_tag',
        'period_end',
        'period_start',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeToday($query){
        return $query->where('creation_date', Carbon::now()->format('Y-m-d'));
    }
}
