<?php

namespace App\Controller\Panel;

use \App\Utils\View;
use \App\Model\Entity\Equipaments as EntityEquipaments;
use \App\Core\Pagination;

class Equipaments extends Page
{
    private static function getEquipamentsItems($request, &$obPagination)
    {
        $itens = '';

        $quantidadeTotal = EntityEquipaments::getEquipaments(null, null, null, "COUNT(*) as qtd")->fetchObject()->qtd;

        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 15);

        $results = EntityEquipaments::getEquipaments(null, "id_simol DESC", $obPagination->getLimit());

        while($obEquipaments = $results->fetchObject(EntityEquipaments::class)) {

            $itens .= View::render('painel/modules/equipaments/item',[
                'id_simol' => $obEquipaments->id_simol,
                'titulo'  => $obEquipaments->titulo,
                'tipo_transporte' => $obEquipaments->tipo_transporte,
                'forma_envio' => $obEquipaments->forma_envio,
                'data_inclusao' => date('d/m/Y H:i:s', strtotime($obEquipaments->data_inclusao))
            ]);
        }

        return $itens;
    }

    public static function getEquipaments($request)
    {
        $content = View::render('painel/modules/equipaments/index',[
            'itens' => self::getEquipamentsItems($request, $obPagination)
        ]);

        return parent::getPanel('SIMOL', $content, 'simol');
    }

    public static function getNewEquipaments($request)
    {
        $content = View::render('painel/modules/equipaments/form',[
            'title' => 'Cadastrar GTM',
            'titulo' => '',
            'tipo_transporte' => '',
            'forma_envio' => '',
            'data_inclusao' => '',
            'status' => ''
        ]);

        return parent::getPage('Cadastrar GTM', $content);
    }

    public static function setNewEquipaments($request)
    {
        $postVars = $request->getPostVars();

        $obEquipaments = new EntityEquipaments();
        $obEquipaments->titulo = $postVars['titulo'];
        $obEquipaments->tipo_transporte = $postVars['tipo_transporte'];
        $obEquipaments->forma_envio = $postVars['forma_envio'];
        $obEquipaments->cadastrar();

        $request->getRouter()->redirect('/equipaments?status=created');
    }




    public static function getStatus($request)
    {
        $queryParams = $request->getQueryParams();

        if(!isset($queryParams['status'])) return '';

        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('GTM criado com sucesso');
                break;
        }
    }
}