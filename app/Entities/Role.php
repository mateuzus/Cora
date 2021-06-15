<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Role.
 *
 * @package namespace App\Entities;
 */
class Role extends Model implements Transformable
{
    use TransformableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug'
    ];


    public function users(){
        return $this->belongsToMany(User::class, "user_roles", "role_id");
    }
    public function permissions(){
        return $this->belongsToMany(Permission::class, "roles_permissions", "role_id");
    }

}
