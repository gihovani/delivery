<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    const DEFAULT_ZIPCODE = '00000-000';
    const DEFAULT_STREET = '-';
    const DEFAULT_NEIGHBORHOOD = '-';
    const DEFAULT_CITY = '-';
    const DEFAULT_STATE = 'SC';
    const DEFAULT_NUMBER = '0';
    protected $fillable = ['zipcode', 'street', 'number', 'city', 'state', 'neighborhood', 'complement'];

    public static function ufs()
    {
        return [
            'AC' => 'Acre',
            'AL' => 'Alagoas',
            'AP' => 'Amapá',
            'AM' => 'Amazonas',
            'BA' => 'Bahia',
            'CE' => 'Ceará',
            'DF' => 'Distrito Federal',
            'ES' => 'Espírito Santo',
            'GO' => 'Goiás',
            'MA' => 'Maranhão',
            'MT' => 'Mato Grosso',
            'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais',
            'PA' => 'Pará',
            'PB' => 'Paraíba ',
            'PR' => 'Paraná',
            'PE' => 'Pernambuco',
            'PI' => 'Piauí',
            'RJ' => 'Rio de Janeiro',
            'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul ',
            'RO' => 'Rondônia',
            'RR' => 'Roraima',
            'SC' => 'Santa Catarina ',
            'SP' => 'São Paulo ',
            'SE' => 'Sergipe',
            'TO' => 'Tocantins'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
