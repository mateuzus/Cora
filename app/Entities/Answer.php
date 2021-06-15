<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Answer.
 *
 * @package namespace App\Entities;
 */
class Answer extends Model implements Transformable
{
    use TransformableTrait;
    public $table = 'answers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creation_date',
        'message',
        'solution',
        'author_id',
        'topic_id'
    ];

}
