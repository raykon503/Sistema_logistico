<?php


use App\Http\Response;
use App\Controller\Login;

$obRouter->get('/login', [
    'middlewares' => [
        'required-logout'
    ],
    function ($request) {
        return new Response(200, Login\Login::getLogin($request));
    }
]);

$obRouter->post('/login', [
    'middlewares' => [
        'required-logout'
    ],
    function ($request) {
        return new Response(200, Login\Login::setLogin($request));
    }
]);

$obRouter->get('/logout', [
    'middlewares' => [
        'required-login'
    ],
    function ($request) {
        return new Response(200, Login\Login::setLogout($request));
    }
]);