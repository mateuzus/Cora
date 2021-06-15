<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Listing.
 *
 * @package namespace App\Entities;
 * @method static select(\Illuminate\Database\Query\Builder $groupBy)
 * @method listingUser(\Illuminate\Contracts\Auth\Authenticatable|null $user)
 */
class Listing extends Model implements Transformable
{
    use TransformableTrait, HasFactory;


    public $table = 'lists';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'network_id',
        'store_id',
        'department_id',
        'team_id',
        'flow_id',
        'flow_rule_id',
        'pop_id',
        'routine_id',
        'description',
        'creation_date',
        'type',
        'status',
        'list_tag',
        'period_start',
        'period_end',
    ];

    protected $statusLabelArray = [
        0 => "NÃO INICIADA",
        1 => "INICIADA",
        2 => "FINALIZADA",
        3 => "FINALIZADA MAS NÃO COMPLETA"
    ];

    protected $typeLabelArray = [
        'flow_of_work' => "Fila de trabalho",
        'prices' => 'Lista de preços',
        'audits' => 'Lista de auditorias',
        'pops' => 'Lista de pop',
        'routines' => 'Lista de rotinas',
        'noncompliances' => 'Lista de inconformidades',
        'resupplements' => 'Lista de ressuprimento'
    ];

    protected $appends = [
        'statusLabel',
        'typeLabel'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function network()
    {
        return $this->belongsTo(Network::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function flow()
    {
        return $this->belongsTo(Flow::class);
    }
    public function pop()
    {
        return $this->belongsTo(OperationStandart::class, 'pop_id');
    }

    public function routine()
    {
        return $this->belongsTo(Routine::class, 'routine_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'list_id');
    }


    public function scopelistingUser($query, User $user)
    {
        return $query->where('user_id', $user->id);
    }

    public function scopeToday($query)
    {
        return $query->where('creation_date', Carbon::now()->format('Y-m-d'));
    }

    public function scopeBeClose($query)
    {
        return $query->where('period_end','<=' ,Carbon::now());
    }
    public function scopeByDate($query, $days)
    {
        return $query->where('creation_date', '>=',Carbon::now()->subDays($days)->format('Y-m-d'));
    }

    public function scopeActive($query)
    {
        return $query->where(function ($q){
            return $q->orWhere('status', 0)->orWhere("status",1);
        });
    }


    public function scopeListingWork($query)
    {
        return $query
            ->where('pop_id', null)
            ->where('routine_id', null)
            ->where('type', 'flow_of_work');
    }

    public function scopeListingNotInicialized($query)
    {
        return $query
            ->where('status', 0);
    }

    public function scopeListingPrices($query)
    {
        return $query
            ->where('pop_id', null)
            ->where('routine_id', null)
            ->where('type', 'prices');
    }

    public function scopeListingAudits($query)
    {
        return $query
            ->where('pop_id', null)
            ->where('routine_id', null)
            ->where('type', 'audits');
    }

    public function scopeListingPops($query)
    {
        return $query
            ->where('pop_id', '!=', null)
            ->where('routine_id', null);
    }

    public function scopeListingRoutines($query)
    {
        return $query
            ->where('pop_id', null)
            ->where('routine_id', '!=', null);
    }

    public function scopeNoncompliances($query)
    {
        return $query
            ->where('pop_id', null)
            ->where('routine_id', null)
            ->where('type', 'noncompliances');
    }

    public function scopeResupplements($query)
    {
        return $query
            ->where('pop_id', null)
            ->where('routine_id', null)
            ->where('type', 'resupplements');
    }

    public function getStatusLabelAttribute($value)
    {

        if(!$this->status){
            return "";
        }
        return $this->statusLabelArray[$this->status];
    }

    public function getTypeLabelAttribute($value)
    {
        if(!$this->type){
            return "";
        }
        return $this->typeLabelArray[$this->type];
    }
}
