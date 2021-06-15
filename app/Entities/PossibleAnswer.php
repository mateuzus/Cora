<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Traits\TransformableTrait;

class PossibleAnswer extends Model
{
    use TransformableTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'description',
        'value',
    ];

    public function question(){
        return $this->belongsTo(Question::class,'question_id');
    }
}
