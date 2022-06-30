<?php

namespace App\Model\Entity;

use \App\Core\Database;

class Equipaments
{
    public $id_simol;
    public $titulo;
    public $tipo_transporte;
    public $forma_envio;
    public $data_inclusao;


    public function cadastrar()
    {
        //DEFINE A DATA
        $this->data_inclusao = date('Y-m-d H:i:s');

        $this->id_simol = (new Database('SiMol'))->insert([
            'titulo' => $this->titulo,
            'tipo_transporte' => $this->tipo_transporte,
            'forma_envio' => $this->forma_envio,
            'data_inclusao' => $this->data_inclusao
        ]);

        return true;
    }

    public static function getEquipaments($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('SiMoL'))->select($where, $order, $limit, $fields);
    }
}