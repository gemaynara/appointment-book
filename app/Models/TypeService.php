<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class TypeService extends Model
{
    protected $table = 'type_services';
    protected $primaryKey = 'id';

    public static function listServices()
    {
        return [
            'exam' => "Exame",
            'test' => "Teste",
            'vaccine' => "Vacina",
        ];
    }
}
