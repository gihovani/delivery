<?php

namespace App;

class Address extends Model
{
    const DEFAULT_ZIPCODE = '00000-000';
    const DEFAULT_STREET = 'Pick Up in Store';
    const DEFAULT_NEIGHBORHOOD = '-';
    const DEFAULT_CITY = 'São José';
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

    public static function neighborhoods()
    {
        $ret = [
            'Centro' => 'Centro',
            'Ponta de Baixo' => 'Ponta de Baixo',
            'Fazenda Santo Antônio' => 'Fazenda Santo Antônio',
            'Distrito Industrial' => 'Distrito Industrial',
            'Picadas do Sul' => 'Picadas do Sul',
            'Flor de Nápolis' => 'Flor de Nápolis',
            'Forquilhinha' => 'Forquilhinha',
            'Praia Comprida' => 'Praia Comprida',
            'São Luiz' => 'São Luiz',
            'Roçado' => 'Roçado',
            'Bosque das Mansões' => 'Bosque das Mansões',
            'Potecas' => 'Potecas',
            'Forquilhas' => 'Forquilhas',
            'Sertão do Maruim' => 'Sertão do Maruim',
            'Colônia Santana' => 'Colônia Santana',
            'Barreiros' => 'Barreiros',
            'Nossa Senhora do Rosário' => 'Nossa Senhora do Rosário',
            'Bela Vista' => 'Bela Vista',
            'Jardim Cidade de Florianópolis' => 'Jardim Cidade de Florianópolis',
            'Ipiranga' => 'Ipiranga',
            'Pedregal' => 'Pedregal',
            'Jardim Santiago' => 'Jardim Santiago',
            'Areias' => 'Areias',
            'Serraria' => 'Serraria',
            'Real Parque' => 'Real Parque',
            'Campinas' => 'Campinas',
            'Kobrasol' => 'Kobrasol',
            'Procasa' => 'Procasa',
            'Aririu' => 'Aririu',
            'Barra do Aririú' => 'Barra do Aririú',
            'Caminho Novo' => 'Caminho Novo',
            'Pedra Branca' => 'Pedra Branca',
            'Jardim Aquárius' => 'Jardim Aquárius',
            'Jardim Eldorado' => 'Jardim Eldorado',
            'Jardim das Palmeiras' => 'Jardim das Palmeiras',
            'Jardim Coqueiros' => 'Jardim Coqueiros',
            'Mar Azul' => 'Mar Azul',
            'Morretes' => 'Morretes',
            'Rio Grande' => 'Rio Grande',
            'Ponte do Imaruim' => 'Ponte do Imaruim',
            'Pachecos' => 'Pachecos',
            'Praia de Fora' => 'Praia de Fora',
            'Passa Vinte' => 'Passa Vinte',
            'Enseada do Brito (Ens Brito)' => 'Enseada do Brito (Ens Brito)',
            'Passagem de Maciambú (Ens Brito)' => 'Passagem de Maciambú (Ens Brito)',
            'Balneário Ponta do Papagaio (Ens Brito)' => 'Balneário Ponta do Papagaio (Ens Brito)',
            'Pinheira (Ens Brito)' => 'Pinheira (Ens Brito)',
            'Praia do Meio (Ens Brito)' => 'Praia do Meio (Ens Brito)',
            'Praia do Sonho (Ens Brito)' => 'Praia do Sonho (Ens Brito)',
            'Guarda do Embaú (Ens Brito)' => 'Guarda do Embaú (Ens Brito)',
            'São Sebastião' => 'São Sebastião',
            'Sul do Rio' => 'Sul do Rio',
        ];
        return $ret;
    }

    public static function cities()
    {
        $ret = [
            'Águas Mornas' => 'Águas Mornas',
            'Antônio Carlos' => 'Antônio Carlos',
            'Biguaçu' => 'Biguaçu',
            'Florianópolis' => 'Florianópolis',
            'Palhoça' => 'Palhoça',
            'Santo Amaro da Imperatriz' => 'Santo Amaro da Imperatriz',
            'São José' => 'São José',
            'São Pedro de Alcântara' => 'São Pedro de Alcântara',
            'Governador Celso Ramos' => 'Governador Celso Ramos'
        ];
        return $ret;
    }

    public static function predefined()
    {
        $ret = [
            'Novo' => [
                ''
            ],
            'Cond. Bela Vista' => [
                'zipcode' => '88122-400',
                'street' => 'Rua Mathias Schell',
                'number' => 313,
                'city' => 'São José',
                'state' => 'SC',
                'neighborhood' => 'Sertão do Maruim',
                'complement' => 'Cond. Bela Vista, Bloco:  Ap: '
            ],
            'Cond. Bem-te-vi' => [
                'zipcode' => '88122-400',
                'street' => 'Rua Mathias Schell',
                'number' => 132,
                'city' => 'São José',
                'state' => 'SC',
                'neighborhood' => 'Sertão do Maruim',
                'complement' => 'Cond. Bem-te-vi, Bloco:  Ap: '
            ],
            'Cond. Beija Flor' => [
                'zipcode' => '88122-400',
                'street' => 'Rua Mathias Schell',
                'number' => 22,
                'city' => 'São José',
                'state' => 'SC',
                'neighborhood' => 'Sertão do Maruim',
                'complement' => 'Cond. Beija Flor, Bloco:  Ap:'
            ],
            'Cond. Garden Ville' => [
                'zipcode' => '88122-400',
                'street' => 'Rua Vidal Vicente Andrade',
                'number' => 1290,
                'city' => 'São José',
                'state' => 'SC',
                'neighborhood' => 'Forquilhas',
                'complement' => 'Cond. Garden Ville, Bloco:  Ap: '
            ]
        ];
        return $ret;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDistance()
    {
        return Config::getMapsDistanceApi();
    }

    public function getMapsAddr()
    {
        return $this->number . ' ' . $this->street . ' - ' .
            $this->neighborhood . ',
            ' . $this->city . ' - ' . $this->state;
    }
}
