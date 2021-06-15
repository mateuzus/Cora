<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Operator.
 *
 * @package namespace App\Entities;
 */
class Operator extends Model implements Transformable
{
    use TransformableTrait;

    public $table="operator";

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'store_id',
        'id_user'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
    public function store(){
        return $this->belongsTo(Store::class, 'store_id');
    }


    public function scopeListOperator($query, $network_id){
        $stores = Store::where("network_id", $network_id)->get();
        return $query->whereIn('store_id', $stores->toArray());
    }

    public function getNameAttribute($value){
        return $this->user->name." - ".$this->name;
    }
    public function listings(){
        return $this->hasMany(Listing::class, 'operator_id');
    }
    public function listingToday(){
        return $this->hasMany(Listing::class, 'operator_id')
            ->where("creation_date", Carbon::now());
    }

}
