<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//unauthenticated routes
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
});

//authenticated routes
$router->group(['prefix' => 'api','middleware' => 'auth'], function () use ($router) {
    $router->get('users',  ['uses' => 'UserController@showAll']);
    $router->get('users/{id:[0-9]+}', ['uses' => 'UserController@showOneUser']);
});
