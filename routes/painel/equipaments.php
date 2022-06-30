<?php

use \App\Http\Response;
use \App\Controller\Panel;

$obRouter->get('/equipaments',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200, Panel\Equipaments::getEquipaments($request));
    }
]);

$obRouter->get('/equipaments/new',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200,Panel\Equipaments::getNewEquipaments($request));
    }
]);

$obRouter->post('/equipaments',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200,Panel\Equipaments::setNewEquipaments($request));
    }
]);