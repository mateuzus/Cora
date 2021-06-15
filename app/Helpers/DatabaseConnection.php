<?php


namespace App\Helpers;


use Illuminate\Support\Facades\DB;

/**
 * Class DatabaseConnection
 * @package App\Helpers
 */
class DatabaseConnection
{
    /**
     * @param array $client
     * @return mixed
     */
    public static function setConnection($nome, array $connection)
    {
        $name = 'database.connections.'.$nome;
        config([$name=>$connection]);
        return DB::connection($nome);
    }

    public static function disconnection($client){
        $name_connection = strtolower($client['name']);
        return DB::disconnect($name_connection);
    }
}
