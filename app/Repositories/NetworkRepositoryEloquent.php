<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\NetworkRepository;
use App\Entities\Network;
use App\Validators\NetworkValidator;
use DB;

/**
 * Class NetworkRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NetworkRepositoryEloquent extends BaseRepository implements NetworkRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Network::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return NetworkValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function create(array $attributes)
    {

        $network = parent::create($attributes);

        if ($network) {
            $network->fontDatas()->createMany([
                [
                    'network_id' => $this->model->id,
                    'type' => "API",
                    'name' => "Alerta de Estoque Virtual",
                ],

                [
                    'network_id' => $this->model->id,
                    'type' => "API",
                    'name' => "Ruptura comercial",
                ],

                [
                    'network_id' => $this->model->id,
                    'type' => "API",
                    'name' => "Ruptura Operacional",
                ],

                [
                    'network_id' => $this->model->id,
                    'type' => "API",
                    'name' => "Estoque Excedente",
                ],

                [
                    'network_id' => $this->model->id,
                    'type' => "API",
                    'name' => "Alerta de Rupturas",
                ],

                [
                    'network_id' => $this->model->id,
                    'type' => "API",
                    'name' => "Departamentos",
                ],

                [
                    'network_id' => $this->model->id,
                    'type' => "API",
                    'name' => "Loja",
                ],

                [
                    'network_id' => $this->model->id,
                    'type' => "API",
                    'name' => "Produtos",
                ]
            ]);
        }

        return $network;
    }

}
